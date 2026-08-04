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
        $totalValue = UserCard::where('user_id', auth()->id())
            ->selectRaw('COALESCE(SUM(value * copies_owned), 0) as total_value')
            ->value('total_value');

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

        // Porcentaje de cartas coleccionadas por set
        $user = auth()->user();
        $setCompletion = DB::table('sets')
            ->leftJoin('cards', 'sets.id', '=', 'cards.set_id')
            ->select(
                'sets.code',
                'sets.name',
                DB::raw('COUNT(DISTINCT cards.id) as total_cards'),
                $user
                    ? DB::raw('COUNT(DISTINCT user_cards.card_id) as collected_cards')
                    : DB::raw('0 as collected_cards')
            )
            ->when($user, function ($q) use ($user) {
                return $q->leftJoin('user_cards', function ($join) use ($user) {
                    $join->on('cards.id', '=', 'user_cards.card_id')
                         ->where('user_cards.user_id', '=', $user->id);
                });
            })
            ->groupBy('sets.id', 'sets.code', 'sets.name')
            ->having('total_cards', '>', 0)
            ->orderBy('collected_cards', 'desc')
            ->get()
            ->map(function($item) {
                $item->percentage = $item->total_cards > 0
                    ? round(($item->collected_cards / $item->total_cards) * 100, 1)
                    : 0;
                return $item;
            });

        return view('dashboard', compact(
            'totalCards', 'totalSets', 'uniqueCards', 'totalValue',
            'seriesStats', 'rarityStats', 'setStats',
            'collectedCount', 'notCollectedCount', 'setCompletion'
        ));
    }
}