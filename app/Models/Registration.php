<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
	use HasFactory;

	protected $fillable = ['user_id', 'master_class_id'];

	public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function masterClass(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(MasterClass::class);
	}
}
