#!/usr/bin/env python3
"""Genera el PHP script con todas las variaciones desde el JSON"""

import json
import os

# Find the JSON file
json_path = '/home/doremon/onepiece-tcg/all_variations.json'

with open(json_path, 'r') as f:
    all_variations = json.load(f)

php_lines = []
php_lines.append('<?php')
php_lines.append('')
php_lines.append('/**')
php_lines.append(' * Script para insertar todas las variaciones de todos los sets')
php_lines.append(' * 1987 variaciones en 19 sets (OP01-OP17, PRB01, PRB02)')
php_lines.append(' * Ejecutar: php insert_variations.php')
php_lines.append(' */')
php_lines.append('')
php_lines.append("require __DIR__ . '/vendor/autoload.php';")
php_lines.append('')
php_lines.append("$app = require_once __DIR__ . '/bootstrap/app.php';")
php_lines.append("$app->make(Illuminate\\Contracts\\Console\\Kernel::class)->bootstrap();")
php_lines.append('')
php_lines.append('use App\\Models\\Card;')
php_lines.append('use App\\Models\\Set;')
php_lines.append('')
php_lines.append('// Mapeo de variaciones: set => [card_id => [variant_urls]]')
php_lines.append('$variations = [')

total_variants = 0
for set_code, variants in all_variations.items():
    php_lines.append(f'    // {set_code}: {len(variants)} variants')
    php_lines.append(f"    '{set_code}' => [")
    
    for card_id, variant_urls in variants.items():
        total_variants += len(variant_urls)
        card_id_escaped = str(card_id).replace("'", "\\'")
        
        # Format variant URLs as PHP array
        urls_list = []
        for url in variant_urls:
            url_escaped = str(url).replace("'", "\\'")
            urls_list.append(f"'{url_escaped}'")
        
        urls_str = ', '.join(urls_list)
        php_lines.append(f"        '{card_id_escaped}' => [{urls_str}],")
    
    php_lines.append('    ],')
    php_lines.append('')

php_lines.append('];')
php_lines.append('')
php_lines.append('$inserted = 0;')
php_lines.append('$skipped = 0;')
php_lines.append('$set_map = [')
php_lines.append("    'OP01' => 'OP-01', 'OP02' => 'OP-02', 'OP03' => 'OP-03', 'OP04' => 'OP-04',")
php_lines.append("    'OP05' => 'OP-05', 'OP06' => 'OP-06', 'OP07' => 'OP-07', 'OP08' => 'OP-08',")
php_lines.append("    'OP09' => 'OP-09', 'OP10' => 'OP-10', 'OP11' => 'OP-11', 'OP12' => 'OP-12',")
php_lines.append("    'OP13' => 'OP-13', 'OP14' => 'OP-14', 'OP15' => 'OP-15', 'OP16' => 'OP-16',")
php_lines.append("    'OP17' => 'OP-17', 'PRB01' => 'PRB-01', 'PRB02' => 'PRB-02',")
php_lines.append('];')
php_lines.append('')
php_lines.append('foreach ($variations as $setCode => $cardVariants) {')
php_lines.append('    // Find the set')
php_lines.append('    $setCodeMapped = $set_map[$setCode] ?? null;')
php_lines.append('    if (!$setCodeMapped) {')
php_lines.append('        echo "Set $setCode not found in map, skipping\\n";')
php_lines.append('        continue;')
php_lines.append('    }')
php_lines.append('    ')
php_lines.append('    $set = Set::where(\'code\', $setCodeMapped)->first();')
php_lines.append('    if (!$set) {')
php_lines.append('        echo "Set $setCodeMapped not found, skipping\\n";')
php_lines.append('        continue;')
php_lines.append('    }')
php_lines.append('    ')
php_lines.append('    foreach ($cardVariants as $cardId => $variantUrls) {')
php_lines.append('        // Check if base card exists')
php_lines.append('        $baseCard = Card::where(\'set_id\', $set->id)->where(\'card_number\', $cardId)->first();')
php_lines.append('        if (!$baseCard) {')
php_lines.append('            echo "Base card $cardId not found in set $setCodeMapped, skipping\\n";')
php_lines.append('            continue;')
php_lines.append('        }')
php_lines.append('        ')
php_lines.append('        // Create variation cards')
php_lines.append('        foreach ($variantUrls as $variantUrl) {')
php_lines.append('            // Extract variant number from URL')
php_lines.append('            // URL format: https://images.onepiecedb.io/images/OP01/OP01-001_variant1.png')
php_lines.append('            $filename = basename($variantUrl);')
php_lines.append("            $variantNumber = $cardId . 'v' . explode('_variant', $filename)[1];")
php_lines.append('            ')
php_lines.append('            // Check if variation already exists')
php_lines.append("            $existing = Card::where('set_id', $set->id)->where('card_number', $variantNumber)->first();")
php_lines.append('            if ($existing) {')
php_lines.append('                $skipped++;')
php_lines.append('                continue;')
php_lines.append('            }')
php_lines.append('            ')
php_lines.append('            // Create variation card')
php_lines.append('            Card::create([')
php_lines.append("                'set_id' => $set->id,")
php_lines.append("                'rarity_id' => $baseCard->rarity_id,")
php_lines.append("                'card_number' => $variantNumber,")
php_lines.append("                'name' => $baseCard->name,")
php_lines.append("                'character' => $baseCard->character,")
php_lines.append("                'type' => $baseCard->type,")
php_lines.append("                'cost' => $baseCard->cost,")
php_lines.append("                'power' => $baseCard->power,")
php_lines.append("                'health' => $baseCard->health,")
php_lines.append("                'color' => $baseCard->color,")
php_lines.append("                'attribute' => $baseCard->attribute,")
php_lines.append("                'value' => 0,")
php_lines.append("                'price_paid' => 0,")
php_lines.append("                'quantity' => 1,")
php_lines.append("                'image_url' => $variantUrl,")
php_lines.append('            ]);')
php_lines.append('            ')
php_lines.append('            $inserted++;')
php_lines.append('        }')
php_lines.append('    }')
php_lines.append('}')
php_lines.append('')
php_lines.append('echo "\\n=== Variations Import Complete ===\\n";')
php_lines.append('echo "Inserted: {$inserted}\\n";')
php_lines.append('echo "Skipped (existing): {$skipped}\\n";')
php_lines.append('echo "Total sets processed: " . count($variations) . "\\n";')

# Write the PHP file
php_content = '\n'.join(php_lines) + '\n'

output_path = '/home/doremon/onepiece-tcg/insert_variations.php'
with open(output_path, 'w') as f:
    f.write(php_content)

print(f"PHP script generated: {output_path}")
print(f"Total variations: {total_variants}")
print(f"File size: {len(php_content)} bytes")
print(f"Lines: {len(php_lines)}")
