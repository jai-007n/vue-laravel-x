<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

#[Unguarded]
class Vendor extends Model
{
    //
    use HasFactory, Searchable;

    public function toSearchableArray()
    {
        return [
            // 'id' => $this->id,
            'name' => $this->name,
            // 'email' => $this->email,
        ];
    }

    // public function searchableAs()
    // {
    //     return 'vendors';
    // }
}
