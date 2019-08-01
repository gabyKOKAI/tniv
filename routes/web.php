<?php

use Illuminate\Http\Request;
use tniv\Sucursale;
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
    $request->session()->put('sucursalesSession', Sucursale::getSucursales());
    if(!Session::get('sucursalSession')){
        $request->session()->put('sucursalSession', Sucursale::getSucursales()->first());
    }
    /*return view('construccion');*/
    return view('welcome');
})->name('home');

Route::get('/home', function (Request $request){
        return redirect('/');
    });

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/usuarios', 'UsuarioController@lista');
    Route::get('/usuario/{id?}', 'UsuarioController@usuario')->name('usuario');
    Route::post('/usuario/{id?}', 'UsuarioController@usuario')->name('usuarioP');
    Route::put('/usuario/guardar/{id?}','UsuarioController@guardar');

    #Route::get('/registraUsuario',function () {return view('auth.register');});


    Route::get('/sucursales', 'SucursalController@lista');
    Route::get('/sucursalSelected/{id}', function (Request $request, $id) {
        $suc = Sucursale::where('id','=',$id)->first();
        $request->session()->put('sucursalSession', $suc);
        #return back()->with('success', 'Cambiaste a la sucursal '.$suc->nombre);
        #return redirect('/meses/')->with('success', 'Cambiaste a la sucursal '.$suc->nombre);
        return redirect('/')->with('success', 'Cambiaste a la sucursal '.$suc->nombre);
    });
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
    Route::post('/clientesP', 'ClienteController@lista')->name('clientesP');
    Route::get('/clientes/{id?}', 'ClienteController@cliente')->name('cliente');

});
