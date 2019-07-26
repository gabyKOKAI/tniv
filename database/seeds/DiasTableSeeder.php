<?php

use Illuminate\Database\Seeder;
use tniv\Mese;
use tniv\Dia;

class DiasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $dias = [
            [1,'lunes',1,8],
            [2,'martes',1,8],
            [3,'miercoles',1,8],
            [4,'jueves',1,8],
            [5,'viernes',1,8],
            [6,'sabado',0,8],
            [7,'domingo',0,8],
            [8,'lunes',1,8],
            [9,'martes',1,8],
            [10,'miercoles',1,8],
            [11,'jueves',1,8],
            [12,'viernes',1,8],
            [13,'sabado',0,8],
            [14,'domingo',0,8],
            [15,'lunes',1,8],
            [16,'martes',1,8],
            [17,'miercoles',1,8],
            [18,'jueves',1,8],
            [19,'viernes',1,8],
            [20,'sabado',0,8],
            [21,'domingo',0,8],
            [22,'lunes',1,8],
            [23,'martes',1,8],
            [24,'miercoles',1,8],
            [25,'jueves',1,8],
            [26,'viernes',1,8],
            [27,'sabado',0,8],
            [28,'domingo',0,8],
            [29,'lunes',1,8],
            [30,'martes',1,8],
            [31,'miercoles',1,8],

            [1,'jueves',1,4],
            [2,'viernes',1,4],
            [3,'sabado',0,4],
            [4,'domingo',0,4],
            [5,'lunes',1,4],
            [6,'martes',1,4],
            [7,'miercoles',1,4],
            [8,'jueves',1,4],
            [9,'viernes',1,4],
            [10,'sabado',0,4],
            [11,'domingo',0,4],
            [12,'lunes',1,4],
            [13,'martes',1,4],
            [14,'miercoles',1,4],
            [15,'jueves',1,4],
            [16,'viernes',1,4],
            [17,'sabado',0,4],
            [18,'domingo',0,4],
            [19,'lunes',1,4],
            [20,'martes',1,4],
            [21,'miercoles',1,4],
            [22,'jueves',1,4],
            [23,'viernes',1,4],
            [24,'sabado',0,4],
            [25,'domingo',0,4],
            [26,'lunes',1,4],
            [27,'martes',1,4],
            [28,'miercoles',1,4],
            [29,'jueves',1,4],
            [30,'viernes',1,4],
            [31,'sabado',0,4]
        ];
        $count = count($dias);
        foreach ($dias as $key => $dia) {

            $mes_id = Mese::where('id', '=', $dia[3])->pluck('id')->first();

            Dia::insert([
                'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'numDia' => $dia[0],
                'diaSemana' => $dia[1],
                'estatus' => $dia[2],
                'mes_id' =>  $mes_id
            ]);
            $count--;
        }
    }
}
