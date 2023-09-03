<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariationOption extends Model
{
    use HasFactory;

    public function variation(): BelongsTo
    {
        return $this->belongsTo(Variation::class);
    }
}
