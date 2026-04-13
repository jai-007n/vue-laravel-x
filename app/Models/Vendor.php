<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

#[Unguarded]
class Vendor extends Model
{
    //
    use HasFactory, Notifiable;

    public function scopeSearchName(Builder $query, ?string $search): Builder
    {
        if (!$search) {
            return $query;
        }
        return $query->when($search, function ($q, $search) {
            $q->where('name', 'like', "%{$search}%");
        });
    }
}
