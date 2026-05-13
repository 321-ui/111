<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterClassModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_master_class_belongs_to_category(): void
    {
        $category = Category::factory()->create();
        $masterClass = MasterClass::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $masterClass->category);
    }

    public function test_master_class_belongs_to_instructor(): void
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $masterClass = MasterClass::factory()->create(['instructor_id' => $instructor->id]);

        $this->assertInstanceOf(User::class, $masterClass->instructor);
    }

    public function test_master_class_has_many_registrations(): void
    {
        $masterClass = MasterClass::factory()->create();

        $this->assertInstanceOf(
            HasMany::class,
            $masterClass->registrations()
        );
    }

    public function test_get_available_slots_returns_correct_count(): void
    {
        $masterClass = MasterClass::factory()->create(['max_participants' => 10]);

        $this->assertEquals(10, $masterClass->getAvailableSlots());
    }

    public function test_get_available_slots_decreases_with_registrations(): void
    {
        $masterClass = MasterClass::factory()->create(['max_participants' => 3]);
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $masterClass->registrations()->create(['user_id' => $user1->id]);
        $masterClass->registrations()->create(['user_id' => $user2->id]);

        $this->assertEquals(1, $masterClass->getAvailableSlots());
    }

    public function test_is_available_returns_true_when_slots_exist(): void
    {
        $masterClass = MasterClass::factory()->create(['max_participants' => 5]);

        $this->assertTrue($masterClass->isAvailable());
    }

    public function test_is_available_returns_false_when_full(): void
    {
        $masterClass = MasterClass::factory()->create(['max_participants' => 1]);
        $user = User::factory()->create();

        $masterClass->registrations()->create(['user_id' => $user->id]);

        $this->assertFalse($masterClass->isAvailable());
    }

    public function test_is_available_returns_false_when_no_slots(): void
    {
        $masterClass = MasterClass::factory()->create(['max_participants' => 0]);

        $this->assertFalse($masterClass->isAvailable());
    }
}
