<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Card;
use App\Models\Set;
use App\Models\Rarity;
use Illuminate\Support\Facades\DB;

class ImportCardsCommand extends Command
{
    protected $signature = 'import:cards {json_path}';
    protected $description = 'Import One Piece TCG cards from scraper JSON';

    public function handle()
    {
        $jsonPath = $this->argument('json_path');

        if (!file_exists($jsonPath)) {
            $this->error("File not found: {$jsonPath}");
            return Command::FAILURE;
        }

        $data = json_decode(file_get_contents($jsonPath), true);
        if (!$data) {
            $this->error("Invalid JSON file");
            return Command::FAILURE;
        }

        $this->info("Importing One Piece TCG data...");
        $this->info("Total series in file: " . ($data['total_series'] ?? 0));
        $this->info("Total cards in file: " . ($data['total_cards'] ?? 0));

        // 1. Create sets
        $this->newLine();
        $this->info("=== Creating Sets ===");
        $seriesMap = $data['series'] ?? [];
        $setsCreated = 0;
        $setsUpdated = 0;

        foreach ($seriesMap as $seriesId => $seriesName) {
            // Parse series code from name (e.g., "ブースターパック 決戦の刻【OP-16】" -> "OP-16")
            if (preg_match('/【([A-Z]+-\d+)】/', $seriesName, $matches)) {
                $code = $matches[1];
                $name = preg_replace('/【[A-Z]+-\d+】/', '', $seriesName);
                $name = trim($name);

                // Determine type
                $type = 'main';
                if (str_contains($seriesName, 'エクストラブースター')) {
                    $type = 'extra';
                } elseif (str_contains($seriesName, 'プレミアムブースター')) {
                    $type = 'premium';
                } elseif (str_contains($seriesName, 'スタートデッキ')) {
                    $type = 'starter';
                } elseif (str_contains($seriesName, 'アルティメットデッキ')) {
                    $type = 'ultimate';
                } elseif (str_contains($seriesName, 'ファミリーデッキ')) {
                    $type = 'family';
                }

                // Determine series (block)
                $block = 'base';
                if (str_contains($code, 'OP-1')) {
                    $block = 'OP-1x';
                } elseif (str_contains($code, 'OP-2')) {
                    $block = 'OP-2x';
                }

                // Determine year
                $year = 2024;
                if (in_array($code, ['OP-01', 'OP-02', 'OP-03', 'OP-04', 'OP-05', 'OP-06'])) {
                    $year = 2023;
                } elseif (in_array($code, ['OP-07', 'OP-08', 'OP-09', 'OP-10', 'OP-11', 'OP-12', 'OP-13', 'OP-14', 'OP-15', 'OP-16', 'OP-17'])) {
                    $year = 2025;
                }

                $set = Set::firstOrCreate(
                    ['code' => $code],
                    [
                        'name' => $name,
                        'type' => $type,
                        'series' => $block,
                        'release_year' => $year,
                        'total_cards' => 0,
                    ]
                );

                if ($set->wasRecentlyCreated) {
                    $setsCreated++;
                } else {
                    $setsUpdated++;
                }
            }
        }

        $this->info("Sets created: {$setsCreated}, updated: {$setsUpdated}");

        // 2. Create rarities if not exist
        $this->newLine();
        $this->info("=== Creating Rarities ===");
        $raritiesConfig = [
            ['name' => 'C', 'color' => '#9ca3af', 'sort_order' => 1],  // Common
            ['name' => 'R', 'color' => '#3b82f6', 'sort_order' => 2],  // Rare
            ['name' => 'SR', 'color' => '#a855f7', 'sort_order' => 3], // Super Rare
            ['name' => 'SSR', 'color' => '#f59e0b', 'sort_order' => 4], // Super Super Rare
            ['name' => 'UR', 'color' => '#ef4444', 'sort_order' => 5], // Ultra Rare
            ['name' => 'LR', 'color' => '#ec4899', 'sort_order' => 6], // Legendary Rare
            ['name' => 'SC', 'color' => '#06b6d4', 'sort_order' => 7], // Secret Common
            ['name' => 'SEC', 'color' => '#f97316', 'sort_order' => 8], // Secret
            ['name' => 'R', 'color' => '#3b82f6', 'sort_order' => 2],
            ['name' => 'L', 'color' => '#ec4899', 'sort_order' => 9], // Leader
            ['name' => 'C', 'color' => '#9ca3af', 'sort_order' => 1],
            ['name' => 'SP', 'color' => '#f59e0b', 'sort_order' => 10], // Special
            ['name' => 'P', 'color' => '#6b7280', 'sort_order' => 11], // Promo
        ];

        // Deduplicate
        $seen = [];
        $uniqueRarities = [];
        foreach ($raritiesConfig as $r) {
            if (!isset($seen[$r['name']])) {
                $seen[$r['name']] = true;
                $uniqueRarities[] = $r;
            }
        }

        $raritiesCreated = 0;
        foreach ($uniqueRarities as $rarity) {
            $existing = Rarity::where('name', $rarity['name'])->first();
            if (!$existing) {
                Rarity::create($rarity);
                $raritiesCreated++;
            }
        }
        $this->info("Rarities created: {$raritiesCreated}");

        // Get all sets and rarities by name
        $setsByCode = Set::pluck('id', 'code')->toArray();
        $raritiesByName = Rarity::pluck('id', 'name')->toArray();

        // Map rarity names from scraper to DB
        $rarityMap = [
            'C' => 'C',
            'R' => 'R',
            'SR' => 'SR',
            'SSR' => 'SSR',
            'UR' => 'UR',
            'LR' => 'LR',
            'L' => 'L',
            'SP' => 'SP',
            'P' => 'P',
            'SC' => 'SC',
            'SEC' => 'SEC',
        ];

        // 3. Import cards
        $this->newLine();
        $this->info("=== Importing Cards ===");
        $cards = $data['cards'] ?? [];
        $totalCards = count($cards);
        $imported = 0;
        $skipped = 0;
        $errors = 0;

        $this->withProgressBar($cards, function ($card) use (&$imported, &$skipped, &$errors, &$setsByCode, &$raritiesByName, $rarityMap) {
            try {
                $cardNumber = $card['CardNumber'] ?? '';
                if (empty($cardNumber)) {
                    $skipped++;
                    return;
                }

                // Skip alt cards (double-sided)
                if (!empty($card['Alt'])) {
                    $skipped++;
                    return;
                }

                // Parse series code from card number (e.g., "OP16-001" -> "OP-16")
                if (preg_match('/^([A-Z]+)(\d{2})-(\d+)$/', $cardNumber, $matches)) {
                    $seriesPrefix = $matches[1]; // OP, EB, ST, PRB
                    $seriesNum = str_pad($matches[2], 2, '0', STR_PAD_LEFT); // 01, 02, ...
                    $cardSeq = $matches[3];

                    $code = "{$seriesPrefix}-{$seriesNum}";

                    // Handle special cases
                    if ($seriesPrefix === 'PRB') {
                        $code = "PRB-{$seriesNum}";
                    }

                    if (!isset($setsByCode[$code])) {
                        $skipped++;
                        return;
                    }

                    $setId = $setsByCode[$code];
                } else {
                    $skipped++;
                    return;
                }

                // Map rarity
                $rarityName = $card['Rarity'] ?? '';
                $rarityId = null;
                if (isset($rarityMap[$rarityName])) {
                    $rarityId = $raritiesByName[$rarityMap[$rarityName]] ?? null;
                }

                // Map type
                $typeMap = [
                    'LEADER' => 'Leader',
                    'CHARACTER' => 'Character',
                    'STAGE' => 'Stage',
                    'EVENT' => 'Event',
                ];
                $type = $typeMap[$card['CardType']] ?? $card['CardType'];

                // Map color
                $colorMap = [
                    '赤' => 'Rojo',
                    '緑' => 'Verde',
                    '青' => 'Azul',
                    '紫' => 'Morado',
                    '黒' => 'Negro',
                    '黄' => 'Amarillo',
                    '多色' => 'Multicolor',
                ];

                // Create or update card
                Card::updateOrCreate(
                    [
                        'set_id' => $setId,
                        'card_number' => $cardNumber,
                    ],
                    [
                        'name' => $card['Name'] ?? '',
                        'character' => $card['Name'] ?? '',
                        'type' => $type,
                        'cost' => $card['CostLife'] ?? null,
                        'power' => $card['Power'] ? (int)$card['Power'] : null,
                        'health' => null,
                        'rarity_id' => $rarityId,
                        'condition' => 'MT',
                        'quantity' => 0,
                        'value' => 0,
                        'notes' => $card['Feature'] ?? null,
                        'image_url' => $card['Image'] ?? null,
                        'color' => $card['Color'] ?? null,
                        'block_icon' => $card['BlockIcon'] ?? null,
                        'attribute' => $card['Attribute'] ?? null,
                        'feature' => $card['Feature'] ?? null,
                        'text' => $card['Text'] ?? null,
                        'is_alt' => false,
                        'is_collected' => false,
                    ]
                );

                $imported++;

            } catch (\Exception $e) {
                $errors++;
            }
        });

        $this->newLine();
        $this->info("=== Import Complete ===");
        $this->info("Cards imported: {$imported}");
        $this->info("Cards skipped (alt/double-sided): {$skipped}");
        $this->info("Errors: {$errors}");

        // Update set total_cards
        $this->newLine();
        $this->info("=== Updating Set Totals ===");
        Set::all()->each(function ($set) {
            $set->update(['total_cards' => $set->cards()->count()]);
        });
        $this->info("Done!");

        return Command::SUCCESS;
    }
}