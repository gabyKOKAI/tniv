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
            'password' => Hash::make('S0p0rt3'),
            'rol' => 'Master'
        ]);

        $user = User::firstOrCreate([
            'email' => 'anapaula@kokai.com.mx',
            'name' => 'Ana Paula Kokai',
            'password' => Hash::make('S0p0rt3'),
            'rol' => 'Master'
        ]);

        $user = User::firstOrCreate([
            'email' => 'admin@kokai.com.mx',
            'name' => 'Admin',
            'password' => Hash::make('S0p0rt3'),
            'rol' => 'Admin'
        ]);

        $user = User::firstOrCreate([
            'email' => 'adminsucursal@kokai.com.mx',
            'name' => 'AdminSucursal',
            'password' => Hash::make('S0p0rt3'),
            'rol' => 'AdminSucursal'
        ]);

        $user = User::firstOrCreate([
            'email' => 'cliente@kokai.com.mx',
            'name' => 'Cliente',
            'password' => Hash::make('S0p0rt3'),
            'rol' => 'Cliente'
        ]);

        $user = User::firstOrCreate([
            'email' => 'clientenuevo@kokai.com.mx',
            'name' => 'ClienteNuevo',
            'password' => Hash::make('S0p0rt3'),
            'rol' => 'ClienteNuevo'
        ]);

        $user = User::firstOrCreate([
            'email' => 'inactivo@kokai.com.mx',
            'name' => 'Inactivo',
            'password' => Hash::make('S0p0rt3'),
            'rol' => 'Inactivo'
        ]);
    }
}
