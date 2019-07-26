<?php

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
        $this->call(UsersTableSeeder::class);
        $this->call(SucursalesTableSeeder::class);
        $this->call(MesesTableSeeder::class);
        $this->call(DiasTableSeeder::class);
    }
}
