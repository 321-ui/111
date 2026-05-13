<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MasterClass;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    private User $instructor;

    private User $student;

    private Category $category;

    private MasterClass $masterClass;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::factory()->create();
        $this->instructor = User::factory()->create(['role' => 'instructor']);
        $this->student = User::factory()->create(['role' => 'visitor']);
        $this->masterClass = MasterClass::factory()->create([
            'instructor_id' => $this->instructor->id,
            'category_id' => $this->category->id,
            'max_participants' => 5,
        ]);
    }

    public function test_user_can_confirm_registration(): void
    {
        $response = $this->actingAs($this->student)->get("/registrations/{$this->masterClass->id}/confirm");

        $response->assertStatus(200);
        $response->assertViewIs('registrations.confirm');
        $response->assertViewHas('masterClass', $this->masterClass);
    }

    public function test_confirm_shows_error_when_full(): void
    {
        $smallClass = MasterClass::factory()->create([
            'instructor_id' => $this->instructor->id,
            'category_id' => $this->category->id,
            'max_participants' => 1,
        ]);
        Registration::create([
            'user_id' => $this->student->id,
            'master_class_id' => $smallClass->id,
        ]);

        $anotherStudent = User::factory()->create();

        $response = $this->actingAs($anotherStudent)->get("/registrations/{$smallClass->id}/confirm");

        $response->assertRedirect(route('categories.show', $this->category->id));
        $response->assertSessionHasErrors('error');
    }

    public function test_user_can_store_registration(): void
    {
        $response = $this->actingAs($this->student)->post("/registrations/{$this->masterClass->id}");

        $response->assertRedirect(route('categories.show', $this->category->id));
        $this->assertDatabaseHas('registrations', [
            'user_id' => $this->student->id,
            'master_class_id' => $this->masterClass->id,
        ]);
    }

    public function test_user_cannot_register_twice(): void
    {
        Registration::create([
            'user_id' => $this->student->id,
            'master_class_id' => $this->masterClass->id,
        ]);

        $response = $this->actingAs($this->student)->post("/registrations/{$this->masterClass->id}");

        $response->assertRedirect(route('categories.show', $this->category->id));
        $response->assertSessionHasErrors('error');
    }

    public function test_user_can_view_my_registrations(): void
    {
        Registration::create([
            'user_id' => $this->student->id,
            'master_class_id' => $this->masterClass->id,
        ]);

        $response = $this->actingAs($this->student)->get('/my-registrations');

        $response->assertStatus(200);
        $response->assertViewIs('registrations.my');
    }
}
