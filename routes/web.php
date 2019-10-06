<?php

use Illuminate\Http\Request;
use tniv\Sucursale;
use tniv\Cita;
use tniv\Cliente;
use tniv\Hora;
use tniv\Dia;
use tniv\Mese;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    $sucursales = Sucursale::getSucursales();

    Hora::cerrarHoraSucursales();
    Dia::cerrarDia();
    Mese::cerrarMes();
    Cita::tomarCitas();

    $request->session()->put('sucursalesSession', $sucursales);
    $proxCitas = Cita::getProximasCitas();
    $request->session()->put('proxCitas', $proxCitas);
    $numCitas = Cita::getNumCitas(-1);
    $request->session()->put('numCitas', $numCitas);
    $numCitasTomPerAg = Cita::getNumCitasTomPerAg(-1);
    $request->session()->put('numCitasTomPerAg', $numCitasTomPerAg);
    $numCitasPosibles = 21*Cliente::getNumServicio($request['id_cliente']);
    $request->session()->put('numCitasPosibles', $numCitasPosibles);

    if(Session::get('sucursalSession1')){
        $suc = Session::get('sucursalSession1');
    }else{
        $suc = Sucursale::where('id','=',$sucursales->first()->id)->first();
    }
    $request->session()->put('sucursalSession', $suc);
    /*return view('construccion');*/
    return view('welcome');
})->name('home');

Route::get('/menuMovil', function (Request $request) {
    if(Session::has('abrirMenu')){
        $request->session()->forget('abrirMenu');
    }else{
        $request->session()->put('abrirMenu', 1);
    }

    //return view('welcome');
    return redirect()->back();
});


Route::get('/home', function (Request $request){
        return redirect('/');
    });

Auth::routes();

Route::get('/unauthorized', function (Request $request){
        return view('errors.unauthorized');
    })->name('unauthorized');

Route::group(['middleware' => ['auth','master']], function () {
});

Route::group(['middleware' => ['auth','admin']], function () {
    Route::get('/usuarios', 'UsuarioController@lista')->name('usuarios');
    Route::get('/usuario/{id?}', 'UsuarioController@usuario')->name('usuario');
    Route::post('/usuario/{id?}', 'UsuarioController@usuario')->name('usuarioP');
    Route::put('/usuario/guardar/{id?}','UsuarioController@guardar');

    #Route::get('/registraUsuario',function () {return view('auth.register');});

    Route::get('/sucursales', 'SucursalController@lista');

});

Route::group(['middleware' => ['auth','adminSucursal']], function () {

    Route::post('/modificaEstatusSucUsu', 'SucursalController@modificaEstatus');

    Route::get('/meses/{ano?}', 'MesController@lista')->name('meses');
    Route::post('/mesesP', 'MesController@lista')->name('mesesP');
    Route::get('anoActual','MesController@anoActual');

    Route::get('/mes/{id?}', 'MesController@mes')->name('mes');
    Route::post('/mes/{id?}', 'MesController@mes')->name('mesP');
    Route::put('/mes/guardar/{id?}','MesController@guardar');
    Route::get('mesVecino/{dir}/{id}','MesController@mesVecino');
    Route::get('mesActual','MesController@mesActual');

    Route::post('/abrirCerrarDia/{tipo}', 'DiaController@abrirCerrarDia');
    Route::get('/dia/{id?}', 'DiaController@dia')->name('dia');
    Route::get('diaVecino/{dir}/{id}','DiaController@diaVecino');
    Route::get('diaActual','DiaController@diaActual');

    Route::post('/abrirCerrarHora', 'HoraController@abrirCerrarHora');

    Route::get('/clientes', 'ClienteController@lista')->name('clientes');
    Route::get('/cliente/{id?}', 'ClienteController@cliente')->name('cliente');
    Route::post('/clientes', 'ClienteController@lista')->name('clientes');

    Route::post('/agendarCitaACliente','CitaController@agendarCitaACliente');
    Route::get('/tomoCita/{id?}','CitaController@tomarCita');
    Route::get('/perdioCita/{id?}','CitaController@perderCita');
    Route::get('/reagendaCita/{id?}','CitaController@reagendarCita');
});

Route::group(['middleware' => ['auth','cliente']], function () {
    Route::get('/sucursalSelected/{id}','SucursalController@seleccionaSucursal');

    Route::get('/clienteUser/{idUser}', 'ClienteController@clienteUser')->name('clienteUser');
    Route::put('/cliente/guardar/{id?}','ClienteController@guardar');

    Route::get('/agendaCita/{idMes?}/{idDia?}','CitaController@citasDisponibles')->name('agendaCita');
    Route::post('/agendarCita','CitaController@agendarCita');
    Route::post('/agendarValoracion','CitaController@agendarValoracion');
    Route::get('/cancelaCita/{id?}','CitaController@cancelarCita');
    Route::get('/pierdeCita/{id?}','CitaController@perderCita');

});

Route::group(['middleware' => ['auth','clienteNuevo']], function () {
    Route::get('/clienteUser/{idUser}', 'ClienteController@clienteUser')->name('clienteUser');
    Route::put('/cliente/guardar/{id?}','ClienteController@guardar');

    Route::get('/contacto', function () {return view('emails.contacto');});
});

