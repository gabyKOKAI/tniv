<?php

use Illuminate\Database\Seeder;
use tniv\Sucursale;

class SucursalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sucursales = [
            ['CDMX Sucursal','080000', '183000', '140000', 'Calle Isla 31, Col. Ampliación Los Alpes', '(55)1954 3350','(55)2171 5408',3],
            ['CDMX Domicilio','080000', '183000', '140000', 'A domicilio', '(55)1954 3350','(55)2171 5408',1],
            ['Cancún Sucursal','080000', '183000', '140000', 'Plaza Azuna, COnsultorio 822, Av. Sayil, Lote 2 Mzn 5 SM06, Zona Hotelera, Cancún, Quintana Roo', '(998) 214 5652','',3],
            ['Merida Sucursal','080000', '183000', '140000', 'Cenit Medical Center, Calle 15 Nº 501 x 18 y 22, Piso 8, consultorio 805, Fracc. Altabrisa. 97130, Mérida.', '(999) 269 0862','',3],
        ];
        $count = count($sucursales);
        foreach ($sucursales as $key => $sucursal) {
            Sucursale::insert([
                'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'nombre' => $sucursal[0],
                'horaInicio' => $sucursal[1],
                'horaFin' => $sucursal[2],
                'horaComida' => $sucursal[3],
                'direccion' => $sucursal[4],
                'telefono1' => $sucursal[5],
                'telefono2' => $sucursal[6],
                'numCitasMax' => $sucursal[7]
            ]);
            $count--;
        }
    }
}
