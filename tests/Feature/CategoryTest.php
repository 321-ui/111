<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
	use RefreshDatabase;

	public function test_category_page_renders_with_master_classes(): void
	{
		$category = Category::factory()->create();
		$masterClass = MasterClass::factory()->create(['category_id' => $category->id]);

		$response = $this->get("/categories/{$category->id}");

		$response->assertStatus(200);
		$response->assertViewIs('categories.show');
		$response->assertViewHas('category', $category);
		$response->assertViewHas('masterClasses');
	}

	public function test_category_page_requires_valid_category(): void
	{
		$response = $this->get('/categories/99999');

		$response->assertStatus(404);
	}

	public function test_home_page_renders_with_categories(): void
	{
		Category::factory()->count(3)->create();

		$response = $this->get('/');

		$response->assertStatus(200);
		$response->assertViewIs('home');
	}
}