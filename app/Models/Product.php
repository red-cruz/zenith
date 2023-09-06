<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['ratings','price_percentage_diff'];

    public function getPricePercentageDiffAttribute()
    {
        $price = $this->attributes['price'];
        $prev = $this->attributes['prev_price'];
        $percent = round((($price - $prev) / $prev) * 100, 2);
        return $percent.'%';
    }

    public function getRatingsAttribute()
    {
        return [
          'rate' => random_int(1, 5),
          'rators_count' => random_int(1, 999)
        ];
    }

    public function category(): Category
    {
        return Category::find($this->category_id);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class);
    }
}
