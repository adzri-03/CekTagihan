<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Golongan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('tirtohargomaju098'),
            'phone' => fake()->phoneNumber(),
            'role' => 'admin',
            'remember_token' => Str::random(10),
            'status' => true,
        ]);

        $role = Role::create(['name' => 'admin']);
        $user->assignRole($role);
    }
}
