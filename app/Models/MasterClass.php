<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @phpstan-use HasFactory<\Database\Factories\MasterClassFactory>
 */
class MasterClass extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'instructor_id', 'title', 'description', 'date', 'time', 'max_participants', 'price'];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
    ];

    /** @return BelongsTo<Category, MasterClass> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** @return BelongsTo<User, MasterClass> */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /** @return HasMany<Registration, MasterClass> */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function getAvailableSlots(): int
    {
        return $this->max_participants - $this->registrations()->count();
    }

    public function isAvailable(): bool
    {
        return $this->getAvailableSlots() > 0;
    }
}
