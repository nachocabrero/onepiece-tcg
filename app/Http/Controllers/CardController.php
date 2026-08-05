<?php

namespace App\Http\Controllers;

use App\Models\UserCard;
use App\Models\Card;
use App\Models\Set;
use App\Models\Rarity;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $query = UserCard::with(['card.set', 'card.rarity'])
            ->where('user_id', auth()->id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('card', function($cardQuery) use ($search) {
                    $cardQuery->where('name', 'like', "%{$search}%")
                              ->orWhere('card_number', 'like', "%{$search}%")
                              ->orWhere('character', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('set_id')) {
            $query->whereHas('card', function($q) use ($request) {
                $q->where('set_id', $request->set_id);
            });
        }

        if ($request->filled('rarity_id')) {
            $query->whereHas('card', function($q) use ($request) {
                $q->where('rarity_id', $request->rarity_id);
            });
        }

        if ($request->filled('color')) {
            $query->whereHas('card', function($q) use ($request) {
                $q->where('color', $request->color);
            });
        }

        if ($request->filled('duplicates')) {
            $query->where('copies_owned', '>', 1);
        }

        if ($request->filled('no_duplicates')) {
            $query->where('copies_owned', 1);
        }

        $cards = $query->join('cards', 'user_cards.card_id', '=', 'cards.id')
            ->select('user_cards.*')
            ->orderBy('cards.set_id')->orderBy('cards.card_number')->paginate(20);
        $sets = Set::orderBy('code')->get();
        $rarities = Rarity::orderBy('sort_order')->get();

        $collectedCards = UserCard::where('user_id', auth()->id())->count();
        $totalDuplicates = UserCard::where('user_id', auth()->id())->where('copies_owned', '>', 1)->count();
        $totalSpent = UserCard::where('user_id', auth()->id())->sum('price_paid') ?? 0;
        $totalMarketValue = UserCard::where('user_id', auth()->id())->get()->sum(function($uc) {
            return (float)($uc->value * $uc->copies_owned);
        }) ?? 0;
        $totalCards = Card::count();

        return view('cards.index', compact('cards', 'sets', 'rarities', 'totalCards', 'collectedCards', 'totalDuplicates', 'totalSpent', 'totalMarketValue'));
    }

    public function create()
    {
        $catalogCards = Card::join('sets', 'cards.set_id', '=', 'sets.id')
            ->select('cards.*')
            ->orderBy('sets.code')->orderBy('card_number')->limit(100)->get();
        $sets = Set::orderBy('code')->get();
        $rarities = Rarity::orderBy('sort_order')->get();
        return view('cards.create', compact('catalogCards', 'sets', 'rarities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'card_id' => 'required|exists:cards,id',
            'copies_owned' => 'required|integer|min:1',
            'condition' => 'required|string|in:MT,LP,MP,HP,DR',
            'price_paid' => 'nullable|numeric|min:0',
            'value' => 'nullable|numeric|min:0',
            'copies_wanted' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $userCard = UserCard::where('user_id', auth()->id())
            ->where('card_id', $validated['card_id'])
            ->first();

        if ($userCard) {
            $userCard->update($validated);
            return redirect()->route('cards.index')->with('success', 'Carta actualizada en la colección.');
        }

        UserCard::create(array_merge($validated, ['user_id' => auth()->id()]));

        return redirect()->route('cards.index')->with('success', 'Carta añadida a la colección.');
    }

    public function edit(UserCard $card)
    {
        if ($card->user_id !== auth()->id()) {
            abort(403);
        }
        $catalogCards = Card::join('sets', 'cards.set_id', '=', 'sets.id')
            ->select('cards.*')
            ->orderBy('sets.code')->orderBy('card_number')->limit(100)->get();
        $sets = Set::orderBy('code')->get();
        $rarities = Rarity::orderBy('sort_order')->get();
        return view('cards.edit', compact('card', 'catalogCards', 'sets', 'rarities'));
    }

    public function update(Request $request, UserCard $card)
    {
        if ($card->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'card_id' => 'required|exists:cards,id',
            'copies_owned' => 'required|integer|min:1',
            'condition' => 'required|string|in:MT,LP,MP,HP,DR',
            'price_paid' => 'nullable|numeric|min:0',
            'value' => 'nullable|numeric|min:0',
            'copies_wanted' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $card->update($validated);
        return redirect()->route('cards.index')->with('success', 'Carta actualizada correctamente.');
    }

    public function destroy(UserCard $card)
    {
        if ($card->user_id !== auth()->id()) {
            abort(403);
        }
        $card->delete();
        return redirect()->route('cards.index')->with('success', 'Carta eliminada de la colección.');
    }

    public function downloadMissingPdf(Request $request)
    {
        // Obtener las cartas que ya tiene el usuario
        $ownedCardIds = UserCard::where('user_id', auth()->id())
            ->pluck('card_id')
            ->toArray();

        // Obtener las cartas del catálogo que NO tiene
        $missingQuery = Card::with(['set', 'rarity'])
            ->whereNotIn('id', $ownedCardIds);

        // Aplicar filtros si se envían
        if ($request->filled('set_id')) {
            $missingQuery->where('set_id', $request->set_id);
        }
        if ($request->filled('rarity_id')) {
            $missingQuery->where('rarity_id', $request->rarity_id);
        }
        if ($request->filled('color')) {
            $missingQuery->where('color', $request->color);
        }
        if ($request->filled('type')) {
            $missingQuery->where('type', $request->type);
        }

        $missingCards = $missingQuery->orderBy('set_id')->orderBy('card_number')->get();

        $totalCatalog = Card::count();
        $ownedCount = count($ownedCardIds);
        $missingCount = $missingCards->count();

        $pdf = Pdf::loadView('cards.missing-pdf', compact(
            'missingCards',
            'totalCatalog',
            'ownedCount',
            'missingCount'
        ));

        return $pdf->download('cartas_faltantes.pdf');
    }

    public function downloadSetPdf($setId, Request $request)
    {
        $set = Set::findOrFail($setId);

        // Obtener las cartas del set que ya tiene el usuario
        $ownedCardIds = UserCard::where('user_id', auth()->id())
            ->where('card_id', function($q) use ($setId) {
                $q->select('id')->from('cards')->where('set_id', $setId);
            })
            ->pluck('card_id')
            ->toArray();

        // Cartas del set que NO tiene
        $missingCards = Card::with(['rarity'])
            ->where('set_id', $setId)
            ->whereNotIn('id', $ownedCardIds)
            ->orderBy('card_number')
            ->get();

        $totalInSet = Card::where('set_id', $setId)->count();
        $ownedInSet = count($ownedCardIds);
        $missingInSet = $missingCards->count();

        $pdf = Pdf::loadView('cards.set-pdf', compact(
            'set',
            'missingCards',
            'totalInSet',
            'ownedInSet',
            'missingInSet'
        ));

        return $pdf->download("faltantes_{$set->code}.pdf");
    }
}