<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterClassTest extends TestCase
{
	use RefreshDatabase;

	private User $instructor;
	private Category $category;

	protected function setUp(): void
	{
		parent::setUp();

		$this->category = Category::factory()->create();
		$this->instructor = User::factory()->create(['role' => 'instructor']);
	}

	public function test_instructor_can_access_cabinet(): void
	{
		$response = $this->actingAs($this->instructor)->get('/cabinet');

		$response->assertStatus(200);
		$response->assertViewIs('master-classes.cabinet');
	}

	public function test_non_instructor_cannot_access_cabinet(): void
	{
		$visitor = User::factory()->create(['role' => 'visitor']);

		$response = $this->actingAs($visitor)->get('/cabinet');

		$response->assertRedirect('/');
		$response->assertSessionHasErrors('error');
	}

	public function test_instructor_can_access_create_page(): void
	{
		$response = $this->actingAs($this->instructor)->get('/master-classes/create');

		$response->assertStatus(200);
		$response->assertViewIs('master-classes.create');
		$response->assertViewHas('categories');
		$response->assertViewHas('timeSlots');
	}

	public function test_instructor_can_store_master_class(): void
	{
		$data = [
			'category_id' => $this->category->id,
			'title' => 'Test Master Class',
			'description' => 'Test description',
			'date' => '2026-06-15',
			'time' => '09:00',
			'max_participants' => 10,
			'price' => 1000.00,
		];

		$response = $this->actingAs($this->instructor)->post('/master-classes', $data);

		$response->assertRedirect(route('cabinet'));
		$this->assertDatabaseHas('master_classes', [
			'title' => 'Test Master Class',
			'instructor_id' => $this->instructor->id,
		]);
	}

	public function test_store_requires_valid_category(): void
	{
		$data = [
			'category_id' => 9999,
			'title' => 'Test Master Class',
			'description' => 'Test description',
			'date' => '2026-06-15',
			'time' => '09:00',
			'max_participants' => 10,
			'price' => 1000.00,
		];

		$response = $this->actingAs($this->instructor)->post('/master-classes', $data);

		$response->assertSessionHasErrors('category_id');
	}

	public function test_store_requires_valid_time_slot(): void
	{
		$data = [
			'category_id' => $this->category->id,
			'title' => 'Test Master Class',
			'description' => 'Test description',
			'date' => '2026-06-15',
			'time' => '25:00',
			'max_participants' => 10,
			'price' => 1000.00,
		];

		$response = $this->actingAs($this->instructor)->post('/master-classes', $data);

		$response->assertSessionHasErrors('time');
	}

	public function test_instructor_can_edit_own_master_class(): void
	{
		$masterClass = MasterClass::factory()->create([
			'instructor_id' => $this->instructor->id,
			'category_id' => $this->category->id,
		]);

		$response = $this->actingAs($this->instructor)->get("/master-classes/{$masterClass->id}/edit");

		$response->assertStatus(200);
		$response->assertViewIs('master-classes.edit');
		$response->assertViewHas('masterClass', $masterClass);
	}

	public function test_instructor_cannot_edit_other_instructor_master_class(): void
	{
		$otherInstructor = User::factory()->create(['role' => 'instructor']);
		$masterClass = MasterClass::factory()->create([
			'instructor_id' => $otherInstructor->id,
		]);

		$response = $this->actingAs($this->instructor)->get("/master-classes/{$masterClass->id}/edit");

		$response->assertStatus(404);
	}

	public function test_instructor_can_update_own_master_class(): void
	{
		$masterClass = MasterClass::factory()->create([
			'instructor_id' => $this->instructor->id,
			'category_id' => $this->category->id,
		]);

		$response = $this->actingAs($this->instructor)->put("/master-classes/{$masterClass->id}", [
			'description' => 'Updated description',
			'price' => 2000.00,
		]);

		$response->assertRedirect(route('cabinet'));
		$this->assertDatabaseHas('master_classes', [
			'id' => $masterClass->id,
			'description' => 'Updated description',
		]);
	}

	public function test_instructor_can_delete_own_master_class(): void
	{
		$masterClass = MasterClass::factory()->create([
			'instructor_id' => $this->instructor->id,
			'category_id' => $this->category->id,
		]);

		$response = $this->actingAs($this->instructor)->delete("/master-classes/{$masterClass->id}");

		$response->assertRedirect(route('cabinet'));
		$this->assertDatabaseMissing('master_classes', ['id' => $masterClass->id]);
	}

	public function test_instructor_can_show_own_master_class(): void
	{
		$masterClass = MasterClass::factory()->create([
			'instructor_id' => $this->instructor->id,
			'category_id' => $this->category->id,
		]);

		$response = $this->actingAs($this->instructor)->get("/master-classes/{$masterClass->id}");

		$response->assertStatus(200);
		$response->assertViewIs('master-classes.show');
	}

	public function test_get_busy_slots_returns_json(): void
	{
		MasterClass::factory()->create([
			'instructor_id' => $this->instructor->id,
			'date' => '2026-06-15',
			'time' => '09:00',
		]);

		$response = $this->getJson('/api/busy-slots', [
			'date' => '2026-06-15',
			'instructor_id' => $this->instructor->id,
		]);

		$response->assertStatus(200);
		$response->assertJsonContains('09:00');
	}
}