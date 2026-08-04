<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCard extends Model
{
    protected $fillable = [
        'user_id',
        'card_id',
        'copies_owned',
        'condition',
        'price_paid',
        'value',
        'copies_wanted',
        'notes',
    ];

    protected $casts = [
        'copies_owned' => 'integer',
        'price_paid' => 'decimal:2',
        'value' => 'decimal:2',
        'copies_wanted' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
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

    public function getTotalSpentAttribute(): float
    {
        return round($this->price_paid * $this->copies_owned, 2);
    }

    public function getTotalMarketValueAttribute(): float
    {
        return round($this->value * $this->copies_owned, 2);
    }
}