<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\MasterClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryModelTest extends TestCase
{
	use RefreshDatabase;

	public function test_category_has_many_master_classes(): void
	{
		$category = Category::factory()->create();

		$this->assertInstanceOf(
			\Illuminate\Database\Eloquent\Relations\HasMany::class,
			$category->masterClasses()
		);
	}

	public function test_category_can_have_multiple_master_classes(): void
	{
		$category = Category::factory()->create();
		MasterClass::factory()->count(3)->create(['category_id' => $category->id]);

		$this->assertCount(3, $category->masterClasses);
	}
}