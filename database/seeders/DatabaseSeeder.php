<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::upsert([
            [
                'email' => 'admin@laravel.com',
                'password' => bcrypt('12345'),
                'name' => 'Admin'
            ]
        ], ['email'], ['email', 'password', 'name']);
    }
}
