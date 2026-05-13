<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @phpstan-use HasFactory<\Database\Factories\CategoryFactory>
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /** @return HasMany<MasterClass, Category> */
    public function masterClasses(): HasMany
    {
        return $this->hasMany(MasterClass::class);
    }
}
