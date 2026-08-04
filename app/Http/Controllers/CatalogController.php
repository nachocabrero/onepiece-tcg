<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Set;
use App\Models\Rarity;
use App\Models\UserCard;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Card::with(['set', 'rarity'])
            ->select('cards.*')
            ->join('sets', 'cards.set_id', '=', 'sets.id');

        // Filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('card_number', 'like', "%{$search}%")
                  ->orWhere('attribute', 'like', "%{$search}%")
                  ->orWhere('feature', 'like', "%{$search}%");
            });
        }

        if ($request->filled('set_id')) {
            $query->where('set_id', $request->set_id);
        }

        if ($request->filled('rarity_id')) {
            $query->where('rarity_id', $request->rarity_id);
        }

        if ($request->filled('color')) {
            $query->where('color', $request->color);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('attribute')) {
            $query->where('attribute', $request->attribute);
        }

        $cards = $query->orderBy('sets.code')
                       ->orderBy('card_number')
                       ->paginate(50);

        $sets = Set::orderBy('code')->get();
        $rarities = Rarity::orderBy('sort_order')->get();

        $colors = Card::select('color')->distinct()->pluck('color');
        $types = Card::select('type')->distinct()->pluck('type');
        $attributes = Card::select('attribute')->distinct()->pluck('attribute');

        // Stats
        $totalCards = Card::count();
        $collectedCount = auth()->check() ? UserCard::where('user_id', auth()->id())->count() : 0;
        $notCollectedCount = $totalCards - $collectedCount;

        // Get user's collected card IDs
        $collectedIds = collect();
        if (auth()->check()) {
            $collectedIds = UserCard::where('user_id', auth()->id())->pluck('card_id');
        }

        return view('catalog.index', compact(
            'cards', 'sets', 'rarities', 'colors', 'types', 'attributes',
            'totalCards', 'collectedCount', 'notCollectedCount', 'collectedIds'
        ));
    }

    public function show(Card $card)
    {
        $card->load(['set', 'rarity']);
        
        $userCard = null;
        $collectedIds = collect();
        if (auth()->check()) {
            $userCard = UserCard::where('user_id', auth()->id())->where('card_id', $card->id)->first();
            $collectedIds = UserCard::where('user_id', auth()->id())->pluck('card_id');
        }
        
        return view('catalog.show', compact('card', 'userCard', 'collectedIds'));
    }

    public function toggleCollected(Card $card)
    {
        $user = auth()->user();
        $userCard = UserCard::where('user_id', $user->id)->where('card_id', $card->id)->first();
        
        if ($userCard) {
            $userCard->delete();
            $message = 'Carta eliminada de la colección';
        } else {
            UserCard::create([
                'user_id' => $user->id,
                'card_id' => $card->id,
                'copies_owned' => 1,
                'condition' => 'MT',
                'price_paid' => 0,
                'value' => 0,
                'copies_wanted' => 0,
            ]);
            $message = 'Carta añadida a la colección';
        }
        
        if (request()->header('X-Requested-With') === 'XMLHttpRequest' || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }
        
        return back()->with('success', $message);
    }
}