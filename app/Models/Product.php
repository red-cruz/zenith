<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    public function category(): Category
    {
        return Category::find($this->category_id);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class);
    }
}
