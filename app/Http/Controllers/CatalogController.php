<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Set;
use App\Models\Rarity;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Card::with(['set', 'rarity']);

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

        if ($request->filled('collected')) {
            if ($request->collected === '1') {
                $query->collected();
            } else {
                $query->notCollected();
            }
        }

        $cards = $query->orderBy('sets.code')
                       ->orderBy('card_number')
                       ->paginate(50);

        $sets = Set::orderBy('code')->get();
        $rarities = Rarity::orderBy('sort_order')->get();

        // Get unique values for filter dropdowns
        $colors = Card::select('color')->distinct()->pluck('color');
        $types = Card::select('type')->distinct()->pluck('type');
        $attributes = Card::select('attribute')->distinct()->pluck('attribute');

        // Stats
        $totalCards = Card::count();
        $collectedCount = Card::collected()->count();
        $notCollectedCount = $totalCards - $collectedCount;

        return view('catalog.index', compact(
            'cards', 'sets', 'rarities', 'colors', 'types', 'attributes',
            'totalCards', 'collectedCount', 'notCollectedCount'
        ));
    }

    public function show(Card $card)
    {
        $card->load(['set', 'rarity']);
        return view('catalog.show', compact('card'));
    }

    public function toggleCollected(Card $card)
    {
        $card->update(['is_collected' => !$card->is_collected]);
        
        if (request()->header('X-Requested-With') === 'XMLHttpRequest' || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_collected' => $card->is_collected,
                'message' => $card->is_collected ? 'Carta añadida a la colección' : 'Carta eliminada de la colección'
            ]);
        }
        
        return back()->with('success', $card->is_collected ? 'Carta añadida a la colección' : 'Carta eliminada de la colección');
    }
}