<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Golongan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(3)->create();

        // User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@example.com',
        // ]);
        Customer::factory(50)->create();

        Golongan::factory(50)->create();

    }
}
