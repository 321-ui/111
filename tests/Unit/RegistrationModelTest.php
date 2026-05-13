<?php

namespace Tests\Unit;

use App\Models\MasterClass;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $registration = Registration::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $registration->user);
    }

    public function test_registration_belongs_to_master_class(): void
    {
        $masterClass = MasterClass::factory()->create();
        $registration = Registration::factory()->create(['master_class_id' => $masterClass->id]);

        $this->assertInstanceOf(MasterClass::class, $registration->masterClass);
    }
}
