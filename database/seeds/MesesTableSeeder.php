<?php

use Illuminate\Database\Seeder;
use tniv\Sucursale;
use tniv\Mese;

class MesesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         #$meses = [
          #  [1,'Cerrado',"CDMX Sucursal"],
          #  [2,'Cerrado',"CDMX Sucursal"],
          #  [7,'Abierto',"CDMX Sucursal"],
          #  [8,'Abierto',"CDMX Sucursal"],
          #  [11,'Inactivo',"CDMX Sucursal"],
          #  [1,'Cerrado',"CDMX Domicilio"],
          #  [2,'Cerrado',"CDMX Domicilio"],
          #  [7,'Abierto',"CDMX Domicilio"],
          #  [8,'Abierto',"CDMX Domicilio"],
          #  [11,'Inactivo',"CDMX Domicilio"],

         $meses = [
            [1,'Cerrado',"Cancún"]
        ];
        $count = count($meses);
        foreach ($meses as $key => $mes) {

            $sucursal_id = Sucursale::where('nombre', 'like', "%$mes[2]%")->pluck('id')->first();

            Mese::insert([
                'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'mes' => $mes[0],
                'ano' => 2019,
                'estatus' => $mes[1],
                'sucursal_id' =>  $sucursal_id
            ]);
            $count--;
        }
    }
}
