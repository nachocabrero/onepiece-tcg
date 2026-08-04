<?php

namespace App\Http\Controllers;

use App\Models\Rarity;
use Illuminate\Http\Request;

class RarityController extends Controller
{
    public function index()
    {
        $rarities = Rarity::withCount('cards')->orderBy('sort_order')->paginate(20);
        return view('rarities.index', compact('rarities'));
    }

    public function create()
    {
        return view('rarities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20|unique:rarities,name',
            'color' => 'required|string|size:7',
            'sort_order' => 'nullable|integer',
        ]);

        Rarity::create($validated);

        return redirect()->route('rarities.index')->with('success', 'Rareza añadida correctamente.');
    }

    public function edit(Rarity $rarity)
    {
        return view('rarities.edit', compact('rarity'));
    }

    public function update(Request $request, Rarity $rarity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20|unique:rarities,name,' . $rarity->id,
            'color' => 'required|string|size:7',
            'sort_order' => 'nullable|integer',
        ]);

        $rarity->update($validated);

        return redirect()->route('rarities.index')->with('success', 'Rareza actualizada correctamente.');
    }

    public function destroy(Rarity $rarity)
    {
        if ($rarity->cards()->count() > 0) {
            return redirect()->route('rarities.index')->with('error', 'No se puede eliminar una rareza con cartas.');
        }
        $rarity->delete();
        return redirect()->route('rarities.index')->with('success', 'Rareza eliminada correctamente.');
    }
}