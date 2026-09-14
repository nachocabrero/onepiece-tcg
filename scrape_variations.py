#!/usr/bin/env python3
"""
Script para scrapear todas las variaciones de todos los sets del One Piece TCG
desde OnePieceDB.io
"""

import json
import time
import subprocess
import sys

# Sets principales a scrapear
SETS = [
    'OP01', 'OP02', 'OP03', 'OP04', 'OP05', 'OP06', 'OP07', 'OP08', 'OP09', 'OP10',
    'OP11', 'OP12', 'OP13', 'OP14', 'OP15', 'OP16', 'OP17',
    'PRB01', 'PRB02'
]

def scrape_set_cards(set_code):
    """Scrape all cards from a set pack page"""
    try:
        result = subprocess.run([
            'browser-use', '--code', f'''
new_tab("https://onepiecedb.io/pack/{set_code}")
'''
        ], capture_output=True, text=True, timeout=30)
        
        time.sleep(2)
        
        # Extract cards
        cards_js = """
(() => {
    const articles = document.querySelectorAll('[data-set-card]');
    const cards = [];
    articles.forEach(article => {
        const cardId = article.getAttribute('data-cardid');
        const name = article.querySelector('p.truncate')?.textContent?.trim() || '';
        const rarity = article.getAttribute('data-card-rarity') || '';
        const color = article.getAttribute('data-card-colors') || '';
        const type = article.getAttribute('data-card-type') || '';
        if (cardId) {
            cards.push({
                id: cardId,
                name: name,
                rarity: rarity,
                color: color,
                type: type
            });
        }
    });
    return JSON.stringify(cards);
})()
"""
        result = subprocess.run([
            'browser-use', '--code', f'js(\'{cards_js.replace(chr(39), chr(92)+chr(39))}\')'
        ], capture_output=True, text=True, timeout=30)
        
        if result.stdout:
            cards = json.loads(result.stdout.strip())
            return cards
    except Exception as e:
        print(f"Error scraping {set_code}: {e}")
    
    return []

def check_card_variations(card_id):
    """Check if a card has variants by visiting its detail page"""
    try:
        # Navigate to card page
        subprocess.run([
            'browser-use', '--code', f'''
new_tab("https://onepiecedb.io/card/{card_id.replace("-", ".")}")
'''
        ], capture_output=True, text=True, timeout=30)
        
        time.sleep(2)
        
        # Get variant images
        variant_js = """
(() => {
    const images = document.querySelectorAll('img');
    const variants = [];
    images.forEach(img => {
        if (img.src && img.src.includes('onepiecedb.io/images') && img.src.includes('variant')) {
            variants.push(img.src);
        }
    });
    return JSON.stringify(variants);
})()
"""
        result = subprocess.run([
            'browser-use', '--code', f'js(\'{variant_js.replace(chr(39), chr(92)+chr(39))}\')'
        ], capture_output=True, text=True, timeout=30)
        
        if result.stdout:
            variants = json.loads(result.stdout.strip())
            return variants
    except Exception as e:
        print(f"Error checking {card_id}: {e}")
    
    return []

def main():
    print("=== One Piece TCG Variation Scraper ===")
    print()
    
    all_cards = {}
    
    # Step 1: Scrape all cards from all sets
    print("Step 1: Scraping all cards...")
    for set_code in SETS:
        print(f"  Scraping {set_code}...")
        cards = scrape_set_cards(set_code)
        print(f"    Found {len(cards)} cards")
        
        for card in cards:
            all_cards[card['id']] = {
                'set': set_code,
                'name': card['name'],
                'rarity': card['rarity'],
                'color': card['color'],
                'type': card['type']
            }
    
    print(f"\nTotal cards: {len(all_cards)}")
    
    # Step 2: Check for variations (sample first to understand pattern)
    print("\nStep 2: Checking for variations...")
    sample_size = min(20, len(all_cards))
    sample_cards = list(all_cards.keys())[:sample_size]
    
    variations_found = {}
    for i, card_id in enumerate(sample_cards):
        print(f"  Checking {i+1}/{sample_size}: {card_id}")
        variants = check_card_variations(card_id)
        if variants:
            variations_found[card_id] = variants
            print(f"    Found {len(variants)} variants!")
    
    print(f"\nVariations found in sample: {len(variations_found)}")
    for card_id, variants in variations_found.items():
        print(f"  {card_id}: {len(variants)} variants")
        for v in variants:
            print(f"    - {v}")
    
    # Save results
    with open('variations_data.json', 'w') as f:
        json.dump({
            'all_cards': all_cards,
            'variations_found': variations_found
        }, f, indent=2)
    
    print("\nData saved to variations_data.json")

if __name__ == '__main__':
    main()
