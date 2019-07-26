<?php

use Illuminate\Database\Seeder;
use tniv\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate([
            'email' => 'gaby@kokai.com.mx',
            'name' => 'Gaby Kokai',
            'password' => Hash::make('S0p0rt3')
        ]);

        $user = User::firstOrCreate([
            'email' => 'anapaula@kokai.com.mx',
            'name' => 'Ana Paula Kokai',
            'password' => Hash::make('S0p0rt3')
        ]);
    }
}
