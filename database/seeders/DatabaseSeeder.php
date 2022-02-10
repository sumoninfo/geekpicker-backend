<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory()->create([
            'name'  => "Admin",
            'phone' => "01720425485",
            'email' => 'admin@gmail.com',
        ]);

        \App\Models\Transaction::factory(10)->create();
    }
}
