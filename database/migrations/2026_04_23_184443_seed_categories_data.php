<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		DB::table('categories')->insert([
			[
				'name' => 'Архитектурное моделирование',
				'description' => 'Архитектурное моделирование — это изготовление моделей зданий, сооружений, исторических памятников, а также инженерных и фортификационных сооружений. Отличительной особенностью образовательной программы является то, что она расширяет пространство.',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'name' => 'Кулинария',
				'description' => 'Мастер-классы по кулинарии научат вас основам приготовления различных блюд. Вы научитесь работать с продуктами, сочетать вкусы и создавать кулинарные шедевры.',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'name' => 'Резьба по дереву',
				'description' => 'Резьба по дереву — искусство создания объемных изображений на деревянной поверхности. На мастер-классах вы освоите основные приемы и инструменты для работы с деревом.',
				'created_at' => now(),
				'updated_at' => now(),
			],
		]);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		//
	}
};
