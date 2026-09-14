<?php

/**
 * Script para insertar todas las cartas promo P (P-001 a P-117)
 * Incluye: líderes, personajes y eventos
 * Ejecutar: php insert_promos.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Card;
use App\Models\Set;
use App\Models\Rarity;

// Crear el set P (Promos) si no existe
$set = Set::firstOrCreate(
    ['code' => 'P'],
    [
        'name' => 'Promotional Cards',
        'type' => 'promo',
        'series' => 'Various',
        'release_year' => 2022,
        'total_cards' => 121,
    ]
);

echo "Set P: ID={$set->id}, cards existentes: " . Card::where('set_id', $set->id)->count() . PHP_EOL;

// Mapeo de raridades
$rarityMap = [
    'promo' => 'C',
    'leader' => 'L',
];

// Obtener IDs de rarezas
$rarityIds = [];
foreach ($rarityMap as $opRarity => $sysRarity) {
    $r = Rarity::firstOrCreate(['name' => $sysRarity], ['color' => '#9ca3af', 'sort_order' => 1]);
    $rarityIds[$opRarity] = $r->id;
}

// Mapeo de colores
$colorMap = [
    'red' => '赤',
    'green' => '緑',
    'blue' => '青',
    'purple' => '紫',
    'black' => '黒',
    'yellow' => '黄',
];

// Cartas promo P (de OnePieceDB)
// 5 líderes + 96 personajes + 7 eventos = 108 cartas
$cards = [
    // LÍDERES (5)
    ['number' => 'P-011', 'name' => 'Uta', 'rarity' => 'leader', 'color' => 'red', 'type' => 'leader', 'cost' => '5', 'power' => '5000', 'health' => '5', 'traits' => 'Elbaph/Red-Haired Pirates'],
    ['number' => 'P-047', 'name' => 'Monkey.D.Luffy', 'rarity' => 'leader', 'color' => 'blue', 'type' => 'leader', 'cost' => '5', 'power' => '5000', 'health' => '5', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-076', 'name' => 'Sakazuki', 'rarity' => 'leader', 'color' => 'blue', 'type' => 'leader', 'cost' => '5', 'power' => '5000', 'health' => '5', 'traits' => 'Navy/Admiral/Fleet Admiral'],
    ['number' => 'P-086', 'name' => 'Trafalgar Law', 'rarity' => 'leader', 'color' => 'red', 'type' => 'leader', 'cost' => '5', 'power' => '5000', 'health' => '5', 'traits' => 'Straw Hat Pirates/Heart Pirates'],
    ['number' => 'P-117', 'name' => 'Nami', 'rarity' => 'leader', 'color' => 'blue', 'type' => 'leader', 'cost' => '5', 'power' => '5000', 'health' => '5', 'traits' => 'Straw Hat Pirates'],

    // PERSONAJES (96)
    ['number' => 'P-001', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '1', 'power' => '1000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-003', 'name' => 'Eustass "Captain" Kid', 'rarity' => 'promo', 'color' => 'green', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Kid Pirates'],
    ['number' => 'P-004', 'name' => 'Crocodile', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '4', 'power' => '7000', 'traits' => 'Baroque Works'],
    ['number' => 'P-005', 'name' => 'Kaido', 'rarity' => 'promo', 'color' => 'purple', 'type' => 'character', 'cost' => '6', 'power' => '8000', 'traits' => 'The Four Emperors/Animal Kingdom Pirates'],
    ['number' => 'P-006', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '1', 'power' => '1000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-007', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-008', 'name' => 'Yamato', 'rarity' => 'promo', 'color' => 'green', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Land of Wano'],
    ['number' => 'P-009', 'name' => 'Trafalgar Law', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Heart Pirates'],
    ['number' => 'P-010', 'name' => 'Kaido', 'rarity' => 'promo', 'color' => 'purple', 'type' => 'character', 'cost' => '5', 'power' => '7000', 'traits' => 'The Four Emperors/Animal Kingdom Pirates'],
    ['number' => 'P-012', 'name' => 'Jellyfish Pirates', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-013', 'name' => 'Gordon', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-014', 'name' => 'Koby', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '3', 'power' => '3000', 'traits' => 'Navy'],
    ['number' => 'P-015', 'name' => 'Sunny-Kun', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '1', 'power' => '1000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-016', 'name' => 'Shanks', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '4', 'power' => '7000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'P-017', 'name' => 'Trafalgar Law', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Heart Pirates'],
    ['number' => 'P-018', 'name' => 'Bartolomeo', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-019', 'name' => 'Bepo', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '1', 'power' => '1000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-020', 'name' => 'Helmeppo', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Navy'],
    ['number' => 'P-021', 'name' => 'Benn.Beckman', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'P-022', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-023', 'name' => 'Yasopp', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'P-025', 'name' => 'Smoker', 'rarity' => 'promo', 'color' => 'black', 'type' => 'character', 'cost' => '4', 'power' => '6000', 'traits' => 'Navy'],
    ['number' => 'P-026', 'name' => 'Morgan', 'rarity' => 'promo', 'color' => 'black', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Navy'],
    ['number' => 'P-027', 'name' => 'General Franky', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-028', 'name' => 'Portgas.D.Ace', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '5', 'power' => '7000', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'P-029', 'name' => 'Bartolomeo', 'rarity' => 'promo', 'color' => 'green', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-030', 'name' => 'Jinbe', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '4', 'power' => '5000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-031', 'name' => 'Uta', 'rarity' => 'promo', 'color' => 'purple', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Red-Haired Pirates'],
    ['number' => 'P-032', 'name' => 'Sengoku', 'rarity' => 'promo', 'color' => 'black', 'type' => 'character', 'cost' => '6', 'power' => '8000', 'traits' => 'Navy/Admiral'],
    ['number' => 'P-033', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '4', 'power' => '6000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-034', 'name' => 'Sanji', 'rarity' => 'promo', 'color' => 'yellow', 'type' => 'character', 'cost' => '2', 'power' => '2000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-035', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'black', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-036', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'yellow', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-037', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'green', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-038', 'name' => 'Trafalgar Law', 'rarity' => 'promo', 'color' => 'black', 'type' => 'character', 'cost' => '4', 'power' => '6000', 'traits' => 'Heart Pirates'],
    ['number' => 'P-039', 'name' => 'Bellamy', 'rarity' => 'promo', 'color' => 'yellow', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Belle Family'],
    ['number' => 'P-040', 'name' => 'Kaido', 'rarity' => 'promo', 'color' => 'purple', 'type' => 'character', 'cost' => '6', 'power' => '8000', 'traits' => 'The Four Emperors/Animal Kingdom Pirates'],
    ['number' => 'P-041', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'purple', 'type' => 'character', 'cost' => '10', 'power' => '12000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-042', 'name' => 'Roronoa Zoro', 'rarity' => 'promo', 'color' => 'yellow', 'type' => 'character', 'cost' => '2', 'power' => '2000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-043', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-044', 'name' => 'Sabo', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '3', 'power' => '4000', 'traits' => 'Revolutionary Army'],
    ['number' => 'P-045', 'name' => 'Roronoa Zoro', 'rarity' => 'promo', 'color' => 'purple', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-046', 'name' => 'Yamato', 'rarity' => 'promo', 'color' => 'purple', 'type' => 'character', 'cost' => '4', 'power' => '6000', 'traits' => 'Land of Wano'],
    ['number' => 'P-048', 'name' => 'Arlong', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Arlong Pirates'],
    ['number' => 'P-049', 'name' => 'Usopp', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-050', 'name' => 'Sanji', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-051', 'name' => 'Shanks', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '4', 'power' => '7000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'P-052', 'name' => 'Dracule Mihawk', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '5', 'power' => '8000', 'traits' => 'Hawk'],
    ['number' => 'P-053', 'name' => 'Nami', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '1', 'power' => '1000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-054', 'name' => 'Monkey.D.Garp', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '5', 'power' => '7000', 'traits' => 'Navy'],
    ['number' => 'P-055', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '5', 'power' => '5000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-056', 'name' => 'Roronoa Zoro', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-061', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'green', 'type' => 'character', 'cost' => '8', 'power' => '10000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-062', 'name' => 'Hody & Hyouzou', 'rarity' => 'promo', 'color' => 'green', 'type' => 'character', 'cost' => '4', 'power' => '5000', 'traits' => 'New Fish-Man Pirates'],
    ['number' => 'P-063', 'name' => 'Jinbe', 'rarity' => 'promo', 'color' => 'green', 'type' => 'character', 'cost' => '4', 'power' => '5000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-064', 'name' => 'Kouzuki Momonosuke', 'rarity' => 'promo', 'color' => 'yellow', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Land of Wano/Kouzuki Clan'],
    ['number' => 'P-065', 'name' => 'Tony Tony.Chopper', 'rarity' => 'promo', 'color' => 'black', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-066', 'name' => 'Boa Hancock', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '4', 'power' => '6000', 'traits' => 'Kuja Pirates'],
    ['number' => 'P-067', 'name' => 'Eustass "Captain" Kid', 'rarity' => 'promo', 'color' => 'green', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Kid Pirates'],
    ['number' => 'P-068', 'name' => 'Sanji', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-069', 'name' => 'Koala', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Revolutionary Army'],
    ['number' => 'P-070', 'name' => 'Carrot', 'rarity' => 'promo', 'color' => 'green', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Mink/Straw Hat Pirates'],
    ['number' => 'P-071', 'name' => 'Marco', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '4', 'power' => '7000', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'P-072', 'name' => 'Ryuma', 'rarity' => 'promo', 'color' => 'green', 'type' => 'character', 'cost' => '5', 'power' => '8000', 'traits' => 'Zombie'],
    ['number' => 'P-073', 'name' => 'Sabo', 'rarity' => 'promo', 'color' => 'yellow', 'type' => 'character', 'cost' => '3', 'power' => '4000', 'traits' => 'Revolutionary Army'],
    ['number' => 'P-074', 'name' => 'Portgas.D.Ace', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '5', 'power' => '7000', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'P-075', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'black', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-077', 'name' => 'Ulti', 'rarity' => 'promo', 'color' => 'purple', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Animal Kingdom Pirates'],
    ['number' => 'P-080', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-081', 'name' => 'Dracule Mihawk', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '5', 'power' => '8000', 'traits' => 'Hawk'],
    ['number' => 'P-082', 'name' => 'Crocodile', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '4', 'power' => '7000', 'traits' => 'Baroque Works'],
    ['number' => 'P-083', 'name' => 'Shanks', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '4', 'power' => '7000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'P-084', 'name' => 'Buggy', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'The Four Emperors/Buggy Pirates'],
    ['number' => 'P-085', 'name' => 'Jewelry Bonney', 'rarity' => 'promo', 'color' => 'yellow', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Heart Pirates'],
    ['number' => 'P-088', 'name' => 'Trafalgar Law', 'rarity' => 'promo', 'color' => 'yellow', 'type' => 'character', 'cost' => '4', 'power' => '6000', 'traits' => 'Heart Pirates'],
    ['number' => 'P-089', 'name' => 'Tony Tony.Chopper', 'rarity' => 'promo', 'color' => 'yellow', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-090', 'name' => 'Charlotte Smoothie', 'rarity' => 'promo', 'color' => 'purple', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Big Mom Pirates'],
    ['number' => 'P-091', 'name' => 'Shirahoshi', 'rarity' => 'promo', 'color' => 'green', 'type' => 'character', 'cost' => '5', 'power' => '7000', 'traits' => 'Ryugu Kingdom'],
    ['number' => 'P-092', 'name' => 'Koby', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '3', 'power' => '3000', 'traits' => 'Navy'],
    ['number' => 'P-093', 'name' => 'Trafalgar Law', 'rarity' => 'promo', 'color' => 'purple', 'type' => 'character', 'cost' => '5', 'power' => '7000', 'traits' => 'Heart Pirates'],
    ['number' => 'P-096', 'name' => 'Girl', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Ryugu Kingdom'],
    ['number' => 'P-097', 'name' => 'Shanks', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '5', 'power' => '7000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'P-098', 'name' => 'Buggy', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'The Four Emperors/Buggy Pirates'],
    ['number' => 'P-099', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'purple', 'type' => 'character', 'cost' => '4', 'power' => '6000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-100', 'name' => 'Marshall.D.Teach', 'rarity' => 'promo', 'color' => 'black', 'type' => 'character', 'cost' => '6', 'power' => '8000', 'traits' => 'The Four Emperors/Blackbeard Pirates'],
    ['number' => 'P-101', 'name' => 'Tony Tony.Chopper', 'rarity' => 'promo', 'color' => 'red', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-102', 'name' => 'Nami', 'rarity' => 'promo', 'color' => 'green', 'type' => 'character', 'cost' => '2', 'power' => '3000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-103', 'name' => 'Portgas.D.Ace', 'rarity' => 'promo', 'color' => 'blue', 'type' => 'character', 'cost' => '5', 'power' => '7000', 'traits' => 'The Four Emperors/Whitebeard Pirates'],
    ['number' => 'P-104', 'name' => 'Shanks', 'rarity' => 'promo', 'color' => 'purple', 'type' => 'character', 'cost' => '5', 'power' => '7000', 'traits' => 'The Four Emperors/Red-Haired Pirates'],
    ['number' => 'P-105', 'name' => 'Sabo', 'rarity' => 'promo', 'color' => 'black', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Revolutionary Army'],
    ['number' => 'P-106', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'yellow', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-107', 'name' => 'Gol.D.Roger', 'rarity' => 'promo', 'color' => 'purple', 'type' => 'character', 'cost' => '7', 'power' => '10000', 'traits' => 'Roger Pirates'],
    ['number' => 'P-108', 'name' => 'Monkey.D.Luffy', 'rarity' => 'promo', 'color' => 'green', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-116', 'name' => 'Nico Robin', 'rarity' => 'promo', 'color' => 'black', 'type' => 'character', 'cost' => '4', 'power' => '7000', 'traits' => 'Straw Hat Pirates'],
    ['number' => 'P-118', 'name' => 'Lilith', 'rarity' => 'promo', 'color' => 'yellow', 'type' => 'character', 'cost' => '3', 'power' => '5000', 'traits' => 'Elbaph'],

    // EVENTOS (7)
    ['number' => 'P-002', 'name' => 'I Smell Adventure Ahead!', 'rarity' => 'promo', 'color' => 'red', 'type' => 'event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'P-024', 'name' => "I'm Gonna Be King of the Pirates!!", 'rarity' => 'promo', 'color' => 'green', 'type' => 'event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'P-057', 'name' => 'Fleeting Lullaby', 'rarity' => 'promo', 'color' => 'green', 'type' => 'event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'P-058', 'name' => 'Where the Wind Blows', 'rarity' => 'promo', 'color' => 'green', 'type' => 'event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'P-059', 'name' => "The World's Continuation", 'rarity' => 'promo', 'color' => 'green', 'type' => 'event', 'cost' => '', 'power' => '', 'traits' => ''],
    ['number' => 'P-060', 'name' => 'Tot Musica', 'rarity' => 'promo', 'color' => 'green', 'type' => 'event', 'cost' => '', 'power' => '', 'traits' => ''],
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
    
    // Mapear color
    $mappedColor = $colorMap[$cardData['color']] ?? $cardData['color'];
    
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
        'color' => $mappedColor,
        'attribute' => $cardData['traits'] ?? null,
        'value' => 0,
        'price_paid' => 0,
        'quantity' => 1,
    ]);
    
    $inserted++;
}

echo PHP_EOL . "=== Promos Import Complete ===" . PHP_EOL;
echo "Inserted: {$inserted}" . PHP_EOL;
echo "Skipped (existing): {$skipped}" . PHP_EOL;
echo "Total in P: " . Card::where('set_id', $set->id)->count() . PHP_EOL;
