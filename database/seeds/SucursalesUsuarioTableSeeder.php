<?php

use Illuminate\Database\Seeder;
use tniv\SucursalesUsuario;

class SucursalesUsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sucursalesUsuario = [
            [1,1,1],
            [1,1,2],
            [1,1,3],
            [1,1,4],
            [1,2,1],
            [0,2,2],
            [0,2,3],
            [1,2,4],
            [1,3,1],
            [1,3,2],
            [1,3,3],
            [1,3,4],
            [1,4,1],
            [1,5,1],
            [1,6,1],
            [1,7,1],
        ];
        $count = count($sucursalesUsuario);
        foreach ($sucursalesUsuario as $key => $sucursalUsuario) {
            SucursalesUsuario::insert([
                'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'estatus' => $sucursalUsuario[0],
                'usuario_id' => $sucursalUsuario[1],
                'sucursal_id' => $sucursalUsuario[2]
            ]);
            $count--;
        }
    }
}
