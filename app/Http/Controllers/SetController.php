<?php

namespace App\Http\Controllers;

use App\Models\Set;
use Illuminate\Http\Request;

class SetController extends Controller
{
    public function index()
    {
        $sets = Set::withCount('cards')->orderBy('code')->paginate(20);
        return view('sets.index', compact('sets'));
    }

    public function create()
    {
        return view('sets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:sets,code',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:main,event,special,promo',
            'series' => 'nullable|string|max:100',
            'release_year' => 'nullable|integer|min:2000|max:2099',
            'total_cards' => 'nullable|integer|min:0',
        ]);

        Set::create($validated);

        return redirect()->route('sets.index')->with('success', 'Set añadido correctamente.');
    }

    public function edit(Set $set)
    {
        return view('sets.edit', compact('set'));
    }

    public function update(Request $request, Set $set)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:sets,code,' . $set->id,
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:main,event,special,promo',
            'series' => 'nullable|string|max:100',
            'release_year' => 'nullable|integer|min:2000|max:2099',
            'total_cards' => 'nullable|integer|min:0',
        ]);

        $set->update($validated);

        return redirect()->route('sets.index')->with('success', 'Set actualizado correctamente.');
    }

    public function destroy(Set $set)
    {
        if ($set->cards()->count() > 0) {
            return redirect()->route('sets.index')->with('error', 'No se puede eliminar un set con cartas.');
        }
        $set->delete();
        return redirect()->route('sets.index')->with('success', 'Set eliminado correctamente.');
    }
}