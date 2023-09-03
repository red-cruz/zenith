<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    public function parentCategory(): HasOne
    {
        return $this->hasOne(ParentCategory::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class);
    }
}
