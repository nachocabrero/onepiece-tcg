<?php

namespace Database\Seeders;

use App\Models\Rarity;
use App\Models\Set;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Raridades del One Piece TCG
        $rarities = [
            ['name' => 'C', 'color' => '#9ca3af', 'sort_order' => 1],
            ['name' => 'R', 'color' => '#3b82f6', 'sort_order' => 2],
            ['name' => 'RR', 'color' => '#8b5cf6', 'sort_order' => 3],
            ['name' => 'SR', 'color' => '#f59e0b', 'sort_order' => 4],
            ['name' => 'SP', 'color' => '#ec4899', 'sort_order' => 5],
            ['name' => 'R', 'color' => '#6366f1', 'sort_order' => 6],
            ['name' => 'UR', 'color' => '#ef4444', 'sort_order' => 7],
            ['name' => 'SSR', 'color' => '#f97316', 'sort_order' => 8],
            ['name' => 'ZSR', 'color' => '#14b8a6', 'sort_order' => 9],
            ['name' => 'Secret R', 'color' => '#a855f7', 'sort_order' => 10],
            ['name' => 'Special R', 'color' => '#06b6d4', 'sort_order' => 11],
            ['name' => 'Trainer R', 'color' => '#22c55e', 'sort_order' => 12],
            ['name' => 'Trainer SP', 'color' => '#eab308', 'sort_order' => 13],
            ['name' => 'Costume R', 'color' => '#f43f5e', 'sort_order' => 14],
            ['name' => 'Costume SP', 'color' => '#d946ef', 'sort_order' => 15],
        ];

        foreach ($rarities as $r) {
            Rarity::firstOrCreate(['name' => $r['name']], $r);
        }

        // Sets de One Piece TCG (OP-01 a OP-15, EB, ST, P)
        $sets = [
            // OP-01: The New World (2022)
            ['code' => 'OP-01', 'name' => 'The New World', 'type' => 'main', 'series' => 'Wano', 'release_year' => 2022, 'total_cards' => 54],
            // OP-02: Intense Battle (2022)
            ['code' => 'OP-02', 'name' => 'Intense Battle', 'type' => 'main', 'series' => 'Wano', 'release_year' => 2022, 'total_cards' => 54],
            // OP-03: Grand Striker (2022)
            ['code' => 'OP-03', 'name' => 'Grand Striker', 'type' => 'main', 'series' => 'Wano', 'release_year' => 2022, 'total_cards' => 54],
            // OP-04: Captain's Chronicles (2022)
            ['code' => 'OP-04', 'name' => "Captain's Chronicles", 'type' => 'main', 'series' => 'Wano', 'release_year' => 2022, 'total_cards' => 40],
            // OP-05: Gear Fifth (2022)
            ['code' => 'OP-05', 'name' => 'Gear Fifth', 'type' => 'main', 'series' => 'Wano', 'release_year' => 2022, 'total_cards' => 54],
            // OP-06: Colosseum (2023)
            ['code' => 'OP-06', 'name' => 'Colosseum', 'type' => 'main', 'series' => 'Dressrosa', 'release_year' => 2023, 'total_cards' => 54],
            // OP-07: Symphonia (2023)
            ['code' => 'OP-07', 'name' => 'Symphonia', 'type' => 'main', 'series' => 'Wano', 'release_year' => 2023, 'total_cards' => 54],
            // OP-08: The Legend Swordsman (2023)
            ['code' => 'OP-08', 'name' => 'The Legend Swordsman', 'type' => 'main', 'series' => 'Wano', 'release_year' => 2023, 'total_cards' => 54],
            // OP-09: The Supreme Military Power (2023)
            ['code' => 'OP-09', 'name' => 'The Supreme Military Power', 'type' => 'main', 'series' => 'Wano', 'release_year' => 2023, 'total_cards' => 54],
            // OP-10: The Worst Generation (2023)
            ['code' => 'OP-10', 'name' => 'The Worst Generation', 'type' => 'main', 'series' => 'Wano', 'release_year' => 2023, 'total_cards' => 54],
            // OP-11: The New Era (2024)
            ['code' => 'OP-11', 'name' => 'The New Era', 'type' => 'main', 'series' => 'Egghead', 'release_year' => 2024, 'total_cards' => 54],
            // OP-12: The Dawn of the Adventure (2024)
            ['code' => 'OP-12', 'name' => 'The Dawn of the Adventure', 'type' => 'main', 'series' => 'Egghead', 'release_year' => 2024, 'total_cards' => 54],
            // OP-13: The Great War (2024)
            ['code' => 'OP-13', 'name' => 'The Great War', 'type' => 'main', 'series' => 'Egghead', 'release_year' => 2024, 'total_cards' => 54],
            // OP-14: The Final Chapter (2025)
            ['code' => 'OP-14', 'name' => 'The Final Chapter', 'type' => 'main', 'series' => 'Final Saga', 'release_year' => 2025, 'total_cards' => 54],
            // OP-15: The Last Adventure (2025)
            ['code' => 'OP-15', 'name' => 'The Last Adventure', 'type' => 'main', 'series' => 'Final Saga', 'release_year' => 2025, 'total_cards' => 54],
            // Event Boosters
            ['code' => 'EB-01', 'name' => 'Event Booster Vol. 1', 'type' => 'event', 'series' => 'Wano', 'release_year' => 2022, 'total_cards' => 12],
            ['code' => 'EB-02', 'name' => 'Event Booster Vol. 2', 'type' => 'event', 'series' => 'Wano', 'release_year' => 2022, 'total_cards' => 12],
            ['code' => 'EB-03', 'name' => 'Event Booster Vol. 3', 'type' => 'event', 'series' => 'Dressrosa', 'release_year' => 2023, 'total_cards' => 12],
            ['code' => 'EB-04', 'name' => 'Event Booster Vol. 4', 'type' => 'event', 'series' => 'Wano', 'release_year' => 2023, 'total_cards' => 12],
            ['code' => 'EB-05', 'name' => 'Event Booster Vol. 5', 'type' => 'event', 'series' => 'Egghead', 'release_year' => 2024, 'total_cards' => 12],
            ['code' => 'EB-06', 'name' => 'Event Booster Vol. 6', 'type' => 'event', 'series' => 'Egghead', 'release_year' => 2024, 'total_cards' => 12],
            ['code' => 'EB-07', 'name' => 'Event Booster Vol. 7', 'type' => 'event', 'series' => 'Final Saga', 'release_year' => 2025, 'total_cards' => 12],
            // Special Trainers
            ['code' => 'ST-01', 'name' => 'The Legend Swordsman', 'type' => 'special', 'series' => 'Wano', 'release_year' => 2023, 'total_cards' => 6],
            ['code' => 'ST-02', 'name' => 'The Worst Generation', 'type' => 'special', 'series' => 'Wano', 'release_year' => 2023, 'total_cards' => 6],
            ['code' => 'ST-03', 'name' => 'The New Era', 'type' => 'special', 'series' => 'Egghead', 'release_year' => 2024, 'total_cards' => 6],
            ['code' => 'ST-04', 'name' => 'The Final Chapter', 'type' => 'special', 'series' => 'Final Saga', 'release_year' => 2025, 'total_cards' => 6],
            // Promos
            ['code' => 'P-001', 'name' => 'Promo Card Set 1', 'type' => 'promo', 'series' => 'Various', 'release_year' => 2022, 'total_cards' => 20],
            ['code' => 'P-002', 'name' => 'Promo Card Set 2', 'type' => 'promo', 'series' => 'Various', 'release_year' => 2023, 'total_cards' => 20],
            ['code' => 'P-003', 'name' => 'Promo Card Set 3', 'type' => 'promo', 'series' => 'Various', 'release_year' => 2024, 'total_cards' => 20],
            ['code' => 'P-004', 'name' => 'Promo Card Set 4', 'type' => 'promo', 'series' => 'Various', 'release_year' => 2025, 'total_cards' => 20],
        ];

        foreach ($sets as $s) {
            Set::firstOrCreate(['code' => $s['code']], $s);
        }
    }
}