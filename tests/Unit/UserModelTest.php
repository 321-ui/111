<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_instructor(): void
    {
        $user = User::factory()->create(['role' => 'instructor']);

        $this->assertTrue($user->isInstructor());
    }

    public function test_user_can_be_visitor(): void
    {
        $user = User::factory()->create(['role' => 'visitor']);

        $this->assertFalse($user->isInstructor());
    }

    public function test_user_has_master_classes_relationship(): void
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(
            HasMany::class,
            $user->masterClasses()
        );
    }

    public function test_user_has_registrations_relationship(): void
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(
            HasMany::class,
            $user->registrations()
        );
    }

    public function test_user_password_is_hashed(): void
    {
        $user = User::factory()->create(['password' => 'plain-text-password']);

        $this->assertNotEquals('plain-text-password', $user->password);
    }
}
