<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Prunable;

    public function prunable(): Builder
    {
        return static::where('deleted_at', '<=', now()->subMonth());
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shopAddress(): HasOne
    {
        return $this->hasOne(ShopAddress::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
