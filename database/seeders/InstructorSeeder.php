<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
	public function run(): void
	{
		User::create([
			'full_name' => 'Инструктор Иван',
			'email' => 'instructor1@test.com',
			'password' => bcrypt('password123'),
			'role' => 'instructor',
			'email_verified' => true,
			'phone' => '89001112233',
		]);

		User::create([
			'full_name' => 'Инструктор Мария',
			'email' => 'instructor2@test.com',
			'password' => bcrypt('password123'),
			'role' => 'instructor',
			'email_verified' => true,
			'phone' => '89004445566',
		]);
	}
}
