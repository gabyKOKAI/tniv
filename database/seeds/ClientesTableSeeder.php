<?php

use Illuminate\Database\Seeder;
use tniv\Cliente;

class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientes = [
            ['Jimena','1', 'cliente@kokai.com.mx', 'Activo', 'Amigo', '5'],
            ['Fernanda','2', 'fer@gmail.com', 'Activo', 'Anuncio', '6'],
            ['Maria','3', 'maria@gmail.com', 'Activo', 'Amigo', '4'],
            ['Macarena','4', 'maca@gmail.com', 'Inactivo', 'Amigo', '7'],
        ];
        $count = count($clientes);
        foreach ($clientes as $key => $cliente) {


            Cliente::insert([
                'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'nombre' => $cliente[0],
                'numCliente' => $cliente[1],
                'correo' => $cliente[2],
                'estatus' => $cliente[3],
                'seEntero' => $cliente[4],
                'user_id' =>  $cliente[5]
            ]);
            $count--;
        }
    }
}
