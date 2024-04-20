<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create(
            [
                'name'=>'1',
                'password' => '123',
                'is_admin' => true
            ]
        );

        \App\Models\User::factory()->create(
            [
                'name'=>'2',
                'password'=>'123',

            ]
        );

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
