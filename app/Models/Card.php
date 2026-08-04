<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    protected $fillable = [
        'set_id',
        'rarity_id',
        'card_number',
        'name',
        'character',
        'type',
        'cost',
        'power',
        'health',
        'ability',
        'condition',
        'quantity',
        'value',
        'notes',
        'image_url',
        'color',
        'block_icon',
        'attribute',
        'feature',
        'text',
        'is_alt',
        'is_collected',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'value' => 'decimal:2',
        'is_alt' => 'boolean',
        'is_collected' => 'boolean',
    ];

    public function set(): BelongsTo
    {
        return $this->belongsTo(Set::class);
    }

    public function rarity(): BelongsTo
    {
        return $this->belongsTo(Rarity::class);
    }

    public function getConditionLabelAttribute(): string
    {
        return match ($this->condition) {
            'MT' => 'Mint',
            'LP' => 'Lightly Played',
            'MP' => 'Moderately Played',
            'HP' => 'Heavily Played',
            'DR' => 'Damaged',
            default => $this->condition,
        };
    }

    public function getConditionColorAttribute(): string
    {
        return match ($this->condition) {
            'MT' => 'text-green-400',
            'LP' => 'text-yellow-400',
            'MP' => 'text-orange-400',
            'HP' => 'text-red-400',
            'DR' => 'text-red-600',
            default => 'text-gray-400',
        };
    }

    // Color name mapping
    public function getColorNameAttribute(): string
    {
        return match ($this->color) {
            '赤' => 'Rojo',
            '緑' => 'Verde',
            '青' => 'Azul',
            '紫' => 'Morado',
            '黒' => 'Negro',
            '黄' => 'Amarillo',
            '多色' => 'Multicolor',
            default => $this->color ?? '',
        };
    }

    public function getColorClassAttribute(): string
    {
        return match ($this->color) {
            '赤' => 'bg-red-500',
            '緑' => 'bg-green-500',
            '青' => 'bg-blue-500',
            '紫' => 'bg-purple-500',
            '黒' => 'bg-gray-900',
            '黄' => 'bg-yellow-400',
            '多色' => 'bg-gradient-to-r from-red-500 via-yellow-400 to-blue-500',
            default => 'bg-gray-500',
        };
    }

    // Scope: only collected cards
    public function scopeCollected($query)
    {
        return $query->where('is_collected', true);
    }

    // Scope: not collected
    public function scopeNotCollected($query)
    {
        return $query->where('is_collected', false);
    }

    // Scope: by color
    public function scopeByColor($query, $color)
    {
        return $query->where('color', $color);
    }

    // Scope: by type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope: by attribute
    public function scopeByAttribute($query, $attribute)
    {
        return $query->where('attribute', $attribute);
    }
}