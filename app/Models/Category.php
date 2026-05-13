<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = ['name', 'description'];

	public function masterClasses(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(MasterClass::class);
	}
}
