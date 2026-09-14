<?php

/**
 * Script para insertar las cartas de OP-17 en la base de datos
 * Ejecutar: php insert_op17.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Card;
use App\Models\Set;
use App\Models\Rarity;

// Crear el set OP-17 si no existe
$set = Set::firstOrCreate(
    ['code' => 'OP-17'],
    [
        'name' => "The World's Strongest Warriors",
        'type' => 'main',
        'series' => 'Elbaph',
        'release_year' => 2026,
        'total_cards' => 119,
    ]
);

echo "Set OP-17: ID={$set->id}, cards existentes: " . Card::where('set_id', $set->id)->count() . PHP_EOL;

// Mapeo de raridades
$rarityMap = [
    'C' => 'C',
    'UC' => 'C',
    'R' => 'R',
    'SR' => 'SR',
    'SP' => 'SP',
    'L' => 'L',
    'SEC' => 'Secret R',
];

// Obtener IDs de rarezas
$rarityIds = [];
foreach ($rarityMap as $opRarity => $sysRarity) {
    $r = Rarity::firstOrCreate(['name' => $sysRarity], ['color' => '#9ca3af', 'sort_order' => 1]);
    $rarityIds[$opRarity] = $r->id;
}

// Cartas OP-17
$cards = [
    // RED cards
    ['number' => 'OP17-001', 'name' => 'Edward Newgate', 'rarity' => 'L', 'color' => '赤', 'type' => 'Leader', 'cost' => '5', 'power' => '5000', 'health' => '5', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'OP17-002', 'name' => 'Atmos', 'rarity' => 'C', 'color' => '赤', 'type' => 'Character', 'cost' => '1', 'power' => '1000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-003', 'name' => 'Izo', 'rarity' => 'R', 'color' => '赤', 'type' => 'Character', 'cost' => '3', 'power' => '5000', 'traits' => 'Land of Wano/Kouzuki Clan'],
    ['number' => 'OP17-004', 'name' => 'Inuarashi & Nekomamushi', 'rarity' => 'C', 'color' => '赤', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Land of Wano/Momo\'s Kingdom'],
    ['number' => 'OP17-005', 'name' => 'Edward Newgate', 'rarity' => 'SR', 'color' => '赤', 'type' => 'Character', 'cost' => '10', 'power' => '12000', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'OP17-006', 'name' => 'Kingdew', 'rarity' => 'C', 'color' => '赤', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'OP17-007', 'name' => 'Kouzuki Oden', 'rarity' => 'R', 'color' => '赤', 'type' => 'Character', 'cost' => '5', 'power' => '6000', 'traits' => 'Land of Wano/Kouzuki Clan'],
    ['number' => 'OP17-008', 'name' => 'Jozu', 'rarity' => 'R', 'color' => '赤', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'OP17-009', 'name' => 'Haruta', 'rarity' => 'UC', 'color' => '赤', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-010', 'name' => 'Fossa', 'rarity' => 'C', 'color' => '赤', 'type' => 'Character', 'cost' => '1', 'power' => '1000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-011', 'name' => 'Blamenco', 'rarity' => 'C', 'color' => '赤', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'OP17-012', 'name' => 'Blenheim', 'rarity' => 'C', 'color' => '赤', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'OP17-013', 'name' => 'Portgas D. Ace', 'rarity' => 'UC', 'color' => '赤', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'OP17-014', 'name' => 'Whitey Bay', 'rarity' => 'C', 'color' => '赤', 'type' => 'Character', 'cost' => '1', 'power' => '1000', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'OP17-015', 'name' => 'Marco', 'rarity' => 'UC', 'color' => '赤', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'OP17-016', 'name' => 'Rakuyo', 'rarity' => 'UC', 'color' => '赤', 'type' => 'Character', 'cost' => '2', 'power' => '5000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-017', 'name' => 'Gurarararara!!!', 'rarity' => 'C', 'color' => '赤', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => 'DON!!'],
    ['number' => 'OP17-018', 'name' => 'The Power to Destroy the World', 'rarity' => 'UC', 'color' => '赤', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-019', 'name' => "I Don't Have Time to Chat with Snot-Nosed Brats", 'rarity' => 'R', 'color' => '赤', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-020', 'name' => 'Shanks', 'rarity' => 'L', 'color' => '緑', 'type' => 'Leader', 'cost' => '5', 'power' => '5000', 'health' => '5', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'OP17-021', 'name' => 'Crone Oli', 'rarity' => 'UC', 'color' => '緑', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-022', 'name' => 'Shanks', 'rarity' => 'SR', 'color' => '緑', 'type' => 'Character', 'cost' => '10', 'power' => '12000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'OP17-023', 'name' => 'Nami', 'rarity' => 'UC', 'color' => '緑', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-024', 'name' => 'Howling Garp', 'rarity' => 'C', 'color' => '緑', 'type' => 'Character', 'cost' => '2', 'power' => '5000', 'traits' => 'Navy'],
    ['number' => 'OP17-025', 'name' => 'Building Snake', 'rarity' => 'UC', 'color' => '緑', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-026', 'name' => 'Fugar', 'rarity' => 'UC', 'color' => '緑', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-027', 'name' => 'Benn Beckman', 'rarity' => 'R', 'color' => '緑', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'OP17-028', 'name' => 'Bonk Punch & Monster', 'rarity' => 'C', 'color' => '緑', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-029', 'name' => 'Hongo', 'rarity' => 'R', 'color' => '緑', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'OP17-030', 'name' => 'Monkey D. Luffy', 'rarity' => 'C', 'color' => '緑', 'type' => 'Character', 'cost' => '1', 'power' => '1000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-031', 'name' => 'Yasopp', 'rarity' => 'SR', 'color' => '緑', 'type' => 'Character', 'cost' => '5', 'power' => '6000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'OP17-032', 'name' => 'Limejuice', 'rarity' => 'R', 'color' => '緑', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'OP17-033', 'name' => 'Lucky Roux', 'rarity' => 'R', 'color' => '緑', 'type' => 'Character', 'cost' => '4', 'power' => '5000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'OP17-034', 'name' => 'Rockstar', 'rarity' => 'C', 'color' => '緑', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'OP17-035', 'name' => 'Roronoa Zoro', 'rarity' => 'C', 'color' => '緑', 'type' => 'Character', 'cost' => '2', 'power' => '2000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-036', 'name' => 'Withdraw Now and Allow Me to Save Face', 'rarity' => 'UC', 'color' => '緑', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-037', 'name' => 'Are You That Scared? "The New Era"!!!', 'rarity' => 'R', 'color' => '緑', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-038', 'name' => "I Think He's Seen an Ugly Future...", 'rarity' => 'C', 'color' => '緑', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-039', 'name' => 'Rocks D. Xebec', 'rarity' => 'L', 'color' => '青', 'type' => 'Leader', 'cost' => '5', 'power' => '5000', 'health' => '5', 'traits' => 'Rocks Pirates'],
    ['number' => 'OP17-040', 'name' => 'Edward Newgate', 'rarity' => 'R', 'color' => '赤', 'type' => 'Character', 'cost' => '6', 'power' => '8000', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'OP17-041', 'name' => 'Wang Zhi', 'rarity' => 'UC', 'color' => '青', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'East Sea'],
    ['number' => 'OP17-042', 'name' => 'Kaido', 'rarity' => 'R', 'color' => '青', 'type' => 'Character', 'cost' => '6', 'power' => '8000', 'traits' => 'The Four Emperors/Animal Kingdom Pirates'],
    ['number' => 'OP17-043', 'name' => 'Ganzui', 'rarity' => 'UC', 'color' => '青', 'type' => 'Character', 'cost' => '2', 'power' => '5000', 'traits' => 'Land of Wano/Momo\'s Kingdom'],
    ['number' => 'OP17-044', 'name' => 'Captain John', 'rarity' => 'UC', 'color' => '青', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-045', 'name' => 'Kyo', 'rarity' => 'UC', 'color' => '青', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Land of Wano/Momo\'s Kingdom'],
    ['number' => 'OP17-046', 'name' => 'Gloriosa', 'rarity' => 'SR', 'color' => '青', 'type' => 'Character', 'cost' => '5', 'power' => '6000', 'traits' => 'Land of Wano/Momo\'s Kingdom'],
    ['number' => 'OP17-047', 'name' => 'Shiki', 'rarity' => 'C', 'color' => '青', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'The Four Emperors'],
    ['number' => 'OP17-048', 'name' => 'Shiki', 'rarity' => 'SR', 'color' => '青', 'type' => 'Character', 'cost' => '6', 'power' => '8000', 'traits' => 'The Four Emperors'],
    ['number' => 'OP17-049', 'name' => 'Charlotte Linlin', 'rarity' => 'R', 'color' => '青', 'type' => 'Character', 'cost' => '6', 'power' => '8000', 'traits' => 'The Four Emperors/Big Mom Pirates'],
    ['number' => 'OP17-050', 'name' => 'Streusen', 'rarity' => 'C', 'color' => '青', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-051', 'name' => 'Jinbe', 'rarity' => 'C', 'color' => '青', 'type' => 'Character', 'cost' => '2', 'power' => '2000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-052', 'name' => 'Don Marlon', 'rarity' => 'C', 'color' => '青', 'type' => 'Character', 'cost' => '1', 'power' => '1000', 'traits' => 'Navy'],
    ['number' => 'OP17-053', 'name' => 'Barbell', 'rarity' => 'C', 'color' => '青', 'type' => 'Character', 'cost' => '1', 'power' => '1000', 'traits' => 'Navy'],
    ['number' => 'OP17-054', 'name' => 'Miss Buckingham Stussy', 'rarity' => 'R', 'color' => '青', 'type' => 'Character', 'cost' => '3', 'power' => '5000', 'traits' => 'Navy/Revolutionary Army'],
    ['number' => 'OP17-055', 'name' => "There's No Authority in the World That Lasts Forever!!!", 'rarity' => 'R', 'color' => '青', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-056', 'name' => 'Rocks Pirates', 'rarity' => 'UC', 'color' => '青', 'type' => 'Character', 'cost' => '6', 'power' => '8000', 'traits' => 'Rocks Pirates'],
    ['number' => 'OP17-057', 'name' => 'Hachinosu', 'rarity' => 'C', 'color' => '青', 'type' => 'Character', 'cost' => '1', 'power' => '1000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-058', 'name' => 'Kaido', 'rarity' => 'L', 'color' => '青', 'type' => 'Leader', 'cost' => '5', 'power' => '5000', 'health' => '5', 'traits' => 'The Four Emperors/Animal Kingdom Pirates'],
    ['number' => 'OP17-059', 'name' => 'Aramaki', 'rarity' => 'UC', 'color' => '青', 'type' => 'Character', 'cost' => '7', 'power' => '8000', 'traits' => 'Navy/Admiral'],
    ['number' => 'OP17-060', 'name' => 'Ulti & Page One', 'rarity' => 'R', 'color' => '青', 'type' => 'Character', 'cost' => '6', 'power' => '6000', 'traits' => 'Animal Kingdom Pirates'],
    ['number' => 'OP17-061', 'name' => 'Greatsword (All-Stars)', 'rarity' => 'R', 'color' => '青', 'type' => 'Character', 'cost' => '9', 'power' => '11000', 'traits' => 'Fish-Man/Animal Kingdom Pirates'],
    ['number' => 'OP17-062', 'name' => 'Kaido', 'rarity' => 'SR', 'color' => '青', 'type' => 'Character', 'cost' => '10', 'power' => '12000', 'traits' => 'The Four Emperors/Animal Kingdom Pirates'],
    ['number' => 'OP17-063', 'name' => 'Kaido', 'rarity' => 'SR', 'color' => '青', 'type' => 'Character', 'cost' => '10', 'power' => '12000', 'traits' => 'The Four Emperors/Animal Kingdom Pirates'],
    ['number' => 'OP17-064', 'name' => 'King', 'rarity' => 'C', 'color' => '紫', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Animal Kingdom Pirates'],
    ['number' => 'OP17-065', 'name' => 'Queen', 'rarity' => 'UC', 'color' => '紫', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'Animal Kingdom Pirates'],
    ['number' => 'OP17-066', 'name' => 'Kurozumi Orochi', 'rarity' => 'C', 'color' => '紫', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Land of Wano'],
    ['number' => 'OP17-067', 'name' => 'Kurozumi Kanjuro', 'rarity' => 'C', 'color' => '紫', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Land of Wano/Kurobe Family'],
    ['number' => 'OP17-068', 'name' => 'Sasaki', 'rarity' => 'C', 'color' => '紫', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Animal Kingdom Pirates'],
    ['number' => 'OP17-069', 'name' => 'Jack', 'rarity' => 'UC', 'color' => '紫', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'Animal Kingdom Pirates'],
    ['number' => 'OP17-070', 'name' => 'Scratchmen Apoo', 'rarity' => 'C', 'color' => '紫', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'The Four Emperors/Blackbeard Pirates'],
    ['number' => 'OP17-071', 'name' => "Who's Who", 'rarity' => 'C', 'color' => '紫', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Animal Kingdom Pirates'],
    ['number' => 'OP17-072', 'name' => 'Black Maria', 'rarity' => 'C', 'color' => '紫', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-073', 'name' => 'Basil Hawkins', 'rarity' => 'UC', 'color' => '紫', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'The Four Emperors/Blackbeard Pirates'],
    ['number' => 'OP17-074', 'name' => 'Yamato', 'rarity' => 'R', 'color' => '紫', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'Land of Wano/Kouzuki Clan'],
    ['number' => 'OP17-075', 'name' => 'X Drake', 'rarity' => 'C', 'color' => '紫', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Navy'],
    ['number' => 'OP17-076', 'name' => "I Think I've Sobered Up", 'rarity' => 'R', 'color' => '紫', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-077', 'name' => 'Kundali Dragon Swarm', 'rarity' => 'UC', 'color' => '紫', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-078', 'name' => 'Drunken Dragon Bagua', 'rarity' => 'C', 'color' => '紫', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-079', 'name' => 'Monkey D. Luffy', 'rarity' => 'L', 'color' => '黒', 'type' => 'Leader', 'cost' => '5', 'power' => '5000', 'health' => '5', 'traits' => 'Elbaph/The Four Emperors/Straw Hat Pirates'],
    ['number' => 'OP17-080', 'name' => 'Usopp', 'rarity' => 'SR', 'color' => '黒', 'type' => 'Character', 'cost' => '2', 'power' => '2000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-081', 'name' => 'Gerd', 'rarity' => 'R', 'color' => '黒', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Giant/Elbaph/New Giant Pirates'],
    ['number' => 'OP17-082', 'name' => 'Sanji', 'rarity' => 'C', 'color' => '黒', 'type' => 'Character', 'cost' => '2', 'power' => '2000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-083', 'name' => 'Jinbe', 'rarity' => 'C', 'color' => '黒', 'type' => 'Character', 'cost' => '2', 'power' => '2000', 'traits' => 'Fish-Man/Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-084', 'name' => 'Tony Tony Chopper', 'rarity' => 'UC', 'color' => '黒', 'type' => 'Character', 'cost' => '1', 'power' => '2000', 'traits' => 'Animal/Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-085', 'name' => 'Dorry', 'rarity' => 'UC', 'color' => '黒', 'type' => 'Character', 'cost' => '5', 'power' => '5000', 'traits' => 'Giant/Elbaph/Giant Pirates'],
    ['number' => 'OP17-086', 'name' => 'Nami', 'rarity' => 'UC', 'color' => '黒', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-087', 'name' => 'Nico Robin', 'rarity' => 'R', 'color' => '黒', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-088', 'name' => 'Hajrudin', 'rarity' => 'C', 'color' => '黒', 'type' => 'Character', 'cost' => '4', 'power' => '5000', 'traits' => 'Giant/Big Mom Pirates'],
    ['number' => 'OP17-089', 'name' => 'Hagwar D. Sauro', 'rarity' => 'R', 'color' => '黒', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'Navy'],
    ['number' => 'OP17-090', 'name' => 'Franky', 'rarity' => 'C', 'color' => '黒', 'type' => 'Character', 'cost' => '2', 'power' => '2000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-091', 'name' => 'Brook', 'rarity' => 'C', 'color' => '黒', 'type' => 'Character', 'cost' => '2', 'power' => '2000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-092', 'name' => 'Brogy', 'rarity' => 'UC', 'color' => '黒', 'type' => 'Character', 'cost' => '4', 'power' => '5000', 'traits' => 'Giant'],
    ['number' => 'OP17-093', 'name' => 'Monkey D. Luffy', 'rarity' => 'SR', 'color' => '黒', 'type' => 'Character', 'cost' => '10', 'power' => '12000', 'traits' => 'Elbaph/The Four Emperors/Straw Hat Pirates'],
    ['number' => 'OP17-094', 'name' => 'Rodo', 'rarity' => 'UC', 'color' => '黒', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Giant/Elbaph'],
    ['number' => 'OP17-095', 'name' => 'Roronoa Zoro', 'rarity' => 'C', 'color' => '黒', 'type' => 'Character', 'cost' => '2', 'power' => '2000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-096', 'name' => "I'm Luffy!! The Man Who Will Be King of the Pirates!!", 'rarity' => 'R', 'color' => '黒', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-097', 'name' => "I'll Feed on This Rage and Use It to Bring the World to Ruin!!!", 'rarity' => 'C', 'color' => '黒', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-098', 'name' => 'Gum-Gum Monkey King Gun', 'rarity' => 'C', 'color' => '黒', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-099', 'name' => 'Charlotte Linlin', 'rarity' => 'L', 'color' => '黄', 'type' => 'Leader', 'cost' => '5', 'power' => '5000', 'health' => '5', 'traits' => 'The Four Emperors/Big Mom Pirates'],
    ['number' => 'OP17-100', 'name' => 'Capone "Gang" Bege', 'rarity' => 'C', 'color' => '黄', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-101', 'name' => 'Caribou', 'rarity' => 'C', 'color' => '黄', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-102', 'name' => 'Charlotte Oven', 'rarity' => 'UC', 'color' => '黄', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-103', 'name' => 'Charlotte Katakuri', 'rarity' => 'UC', 'color' => '黄', 'type' => 'Character', 'cost' => '5', 'power' => '8000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-104', 'name' => 'Charlotte Cracker', 'rarity' => 'UC', 'color' => '黄', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-105', 'name' => 'Charlotte Chiffon', 'rarity' => 'C', 'color' => '黄', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-106', 'name' => 'Charlotte Smoothie', 'rarity' => 'C', 'color' => '黄', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-107', 'name' => 'Charlotte Daifuku', 'rarity' => 'UC', 'color' => '黄', 'type' => 'Character', 'cost' => '4', 'power' => '7000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-108', 'name' => 'Charlotte Brûlée', 'rarity' => 'C', 'color' => '黄', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-109', 'name' => 'Charlotte Pudding', 'rarity' => 'R', 'color' => '黄', 'type' => 'Character', 'cost' => '3', 'power' => '5000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-110', 'name' => 'Charlotte Perospero', 'rarity' => 'C', 'color' => '黄', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-111', 'name' => 'Charlotte Mont-d\'or', 'rarity' => 'C', 'color' => '黄', 'type' => 'Character', 'cost' => '1', 'power' => '1000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-112', 'name' => 'Charlotte Linlin', 'rarity' => 'SR', 'color' => '黄', 'type' => 'Character', 'cost' => '10', 'power' => '12000', 'traits' => 'The Four Emperors/Big Mom Pirates'],
    ['number' => 'OP17-113', 'name' => 'Streusen', 'rarity' => 'R', 'color' => '黄', 'type' => 'Character', 'cost' => '5', 'power' => '6000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'OP17-114', 'name' => 'Sweet 3 Generals', 'rarity' => 'R', 'color' => '黄', 'type' => 'Character', 'cost' => '9', 'power' => '11000', 'traits' => 'Big Mom Pirates/Sweet Commanders'],
    ['number' => 'OP17-115', 'name' => "Don't you know that even in the cruel world of pirates there's still a code of honor?!!", 'rarity' => 'R', 'color' => '黄', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-116', 'name' => 'Fulgora', 'rarity' => 'UC', 'color' => '黄', 'type' => 'Character', 'cost' => '2', 'power' => '3000', 'traits' => 'Elbaph/Straw Hat Pirates'],
    ['number' => 'OP17-117', 'name' => 'Resounding Light Sword', 'rarity' => 'C', 'color' => '黄', 'type' => 'Event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'OP17-118', 'name' => 'Rocks D. Xebec', 'rarity' => 'SEC', 'color' => '青', 'type' => 'Character', 'cost' => '10', 'power' => '12000', 'traits' => 'Rocks Pirates'],
    ['number' => 'OP17-119', 'name' => 'Loki', 'rarity' => 'SEC', 'color' => '黒', 'type' => 'Character', 'cost' => '10', 'power' => '12000', 'traits' => 'Elbaph/Giant Pirates'],
];

$inserted = 0;
$skipped = 0;

foreach ($cards as $cardData) {
    $cardNumber = $cardData['number'];
    
    // Verificar si ya existe
    $existing = Card::where('set_id', $set->id)->where('card_number', $cardNumber)->first();
    if ($existing) {
        $skipped++;
        continue;
    }
    
    // Buscar rarity
    $rarityKey = $cardData['rarity'];
    if (!isset($rarityIds[$rarityKey])) {
        echo "WARNING: Unknown rarity '{$rarityKey}' for {$cardNumber}" . PHP_EOL;
        continue;
    }
    
    Card::create([
        'set_id' => $set->id,
        'rarity_id' => $rarityIds[$rarityKey],
        'card_number' => $cardNumber,
        'name' => $cardData['name'],
        'character' => $cardData['name'],
        'type' => $cardData['type'],
        'cost' => $cardData['cost'] ?? null,
        'power' => $cardData['power'] ?? null,
        'health' => $cardData['health'] ?? null,
        'color' => $cardData['color'],
        'attribute' => $cardData['traits'] ?? null,
        'value' => 0,
        'price_paid' => 0,
        'quantity' => 1,
    ]);
    
    $inserted++;
}

echo PHP_EOL . "=== OP-17 Import Complete ===" . PHP_EOL;
echo "Inserted: {$inserted}" . PHP_EOL;
echo "Skipped (existing): {$skipped}" . PHP_EOL;
echo "Total in OP-17: " . Card::where('set_id', $set->id)->count() . PHP_EOL;
