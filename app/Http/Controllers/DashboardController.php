<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Set;
use App\Models\Rarity;
use App\Models\UserCard;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCards = Card::count();
        $totalSets = Set::count();
        $uniqueCards = Card::where('is_alt', false)->count();
        $collectedCount = UserCard::where('user_id', auth()->id())->count();
        $notCollectedCount = $totalCards - $collectedCount;
        $totalValue = UserCard::where('user_id', auth()->id())->sum(function($uc) {
            return (float)($uc->value * $uc->copies_owned);
        }) ?? 0;

        $seriesStats = Card::selectRaw('sets.series, COUNT(*) as total_cards')
            ->join('sets', 'cards.set_id', '=', 'sets.id')
            ->groupBy('sets.series')
            ->orderByDesc('total_cards')
            ->get();

        $rarityStats = Card::selectRaw('rarities.name, rarities.color, COUNT(*) as total_cards')
            ->join('rarities', 'cards.rarity_id', '=', 'rarities.id')
            ->groupBy('rarities.id', 'rarities.name', 'rarities.color')
            ->orderByDesc('total_cards')
            ->get();

        $setStats = Card::selectRaw('sets.code, sets.name, COUNT(*) as total_cards')
            ->join('sets', 'cards.set_id', '=', 'sets.id')
            ->groupBy('sets.id', 'sets.code', 'sets.name')
            ->orderByDesc('total_cards')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalCards', 'totalSets', 'uniqueCards', 'totalValue',
            'seriesStats', 'rarityStats', 'setStats',
            'collectedCount', 'notCollectedCount'
        ));
    }
}