<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @phpstan-use HasFactory<CategoryFactory>
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /** @return HasMany<MasterClass, $this> */
    public function masterClasses(): HasMany
    {
        return $this->hasMany(MasterClass::class);
    }
}
