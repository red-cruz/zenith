<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ParentCategory extends Model
{
    use HasFactory;

    public function onDelete()
    {
        // This will update the `deleted_at` column to the current timestamp.
        return 'UPDATE users SET deleted_at = NOW() WHERE id = :id';
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
