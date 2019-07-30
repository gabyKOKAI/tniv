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
    $request->session()->put('sucursalSession', Sucursale::getSucursales()->first());
    /*return view('construccion');*/
    return view('welcome');
})->name('home');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/usuarios', 'UsuarioController@lista');

    Route::get('/registraUsuario',function () {
        return view('auth.register');
    });

    Route::get('/sucursales', 'SucursalController@lista');
    Route::get('/sucursalSelected/{id}', function (Request $request, $id) {
        $request->session()->put('sucursalesSession', Sucursale::getSucursales());
        $request->session()->put('sucursalSession', Sucursale::getSucursales()->first());
        $suc = Sucursale::where('id','=',$id)->first();
        $request->session()->put('sucursalSession', $suc);
        #return back()->with('success', 'Cambiaste a la sucursal '.$suc->nombre);
        return redirect('/meses/')->with('success', 'Cambiaste a la sucursal '.$suc->nombre);
    })->name('home');

    Route::get('/meses', 'MesController@lista')->name('meses');
    Route::post('/mesesP', 'MesController@lista')->name('mesesP');
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
