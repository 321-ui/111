<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @phpstan-use HasFactory<\Database\Factories\RegistrationFactory>
 */
class Registration extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'master_class_id'];

    /** @return BelongsTo<User, Registration> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<MasterClass, Registration> */
    public function masterClass(): BelongsTo
    {
        return $this->belongsTo(MasterClass::class);
    }
}
