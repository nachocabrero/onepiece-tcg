<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Set;
use App\Models\Rarity;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $query = Card::with(['set', 'rarity']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('card_number', 'like', "%{$search}%")
                  ->orWhere('character', 'like', "%{$search}%");
            });
        }

        if ($request->filled('set_id')) {
            $query->where('set_id', $request->set_id);
        }

        if ($request->filled('rarity_id')) {
            $query->where('rarity_id', $request->rarity_id);
        }

        $cards = $query->orderBy('sets.code')->orderBy('card_number')->paginate(20);
        $sets = Set::orderBy('code')->get();
        $rarities = Rarity::orderBy('sort_order')->get();

        return view('cards.index', compact('cards', 'sets', 'rarities'));
    }

    public function create()
    {
        $sets = Set::orderBy('code')->get();
        $rarities = Rarity::orderBy('sort_order')->get();
        return view('cards.create', compact('sets', 'rarities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'set_id' => 'required|exists:sets,id',
            'card_number' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'character' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:50',
            'cost' => 'nullable|string|max:10',
            'power' => 'nullable|string|max:10',
            'health' => 'nullable|string|max:10',
            'rarity_id' => 'nullable|exists:rarities,id',
            'condition' => 'required|string|in:MT,LP,MP,HP,DR',
            'quantity' => 'required|integer|min:1',
            'value' => 'nullable|numeric|min:0',
            'ability' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Card::create($validated);

        return redirect()->route('cards.index')->with('success', 'Carta añadida correctamente.');
    }

    public function edit(Card $card)
    {
        $sets = Set::orderBy('code')->get();
        $rarities = Rarity::orderBy('sort_order')->get();
        return view('cards.edit', compact('card', 'sets', 'rarities'));
    }

    public function update(Request $request, Card $card)
    {
        $validated = $request->validate([
            'set_id' => 'required|exists:sets,id',
            'card_number' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'character' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:50',
            'cost' => 'nullable|string|max:10',
            'power' => 'nullable|string|max:10',
            'health' => 'nullable|string|max:10',
            'rarity_id' => 'nullable|exists:rarities,id',
            'condition' => 'required|string|in:MT,LP,MP,HP,DR',
            'quantity' => 'required|integer|min:1',
            'value' => 'nullable|numeric|min:0',
            'ability' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $card->update($validated);

        return redirect()->route('cards.index')->with('success', 'Carta actualizada correctamente.');
    }

    public function destroy(Card $card)
    {
        $card->delete();
        return redirect()->route('cards.index')->with('success', 'Carta eliminada correctamente.');
    }
}