<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Set extends Model
{
    protected $fillable = [
        'code',
        'name',
        'type',
        'series',
        'release_year',
        'total_cards',
    ];

    protected $casts = [
        'release_year' => 'integer',
        'total_cards' => 'integer',
    ];

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }
}