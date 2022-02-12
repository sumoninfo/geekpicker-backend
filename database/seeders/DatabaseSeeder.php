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
            'name'     => "User 1",
            'phone'    => "017XXXXXXXX",
            'email'    => 'user1@gmail.com',
            'currency' => 'USD'
        ]);

        User::factory()->create([
            'name'     => "User 2",
            'phone'    => "017XXXXXXXX",
            'email'    => 'user2@gmail.com',
            'currency' => 'BDT'
        ]);

        //\App\Models\Transaction::factory(10)->create();
    }
}
