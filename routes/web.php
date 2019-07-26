<?php

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

Route::get('/', function () {
    /*return view('construccion');*/
    return view('welcome');
})->name('home');;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/usuarios', 'UsuarioController@lista');

    Route::get('/registraUsuario',function () {
        return view('auth.register');
    });

    Route::get('/sucursales', 'SucursalController@lista');

    Route::get('/meses', 'MesController@lista')->name('meses');
    Route::post('/mesesP', 'MesController@lista')->name('mesesP');
    Route::get('/mes/{id?}', 'MesController@mes')->name('mes');
    Route::post('/mes/{id?}', 'MesController@mes')->name('mesP');
    Route::put('/mes/guardar/{id?}','MesController@guardar');

    Route::post('/abrirCerrarDia/{tipo}', 'DiaController@abrirCerrarDia');
    Route::get('/dia/{id?}', 'DiaController@dia')->name('dia');

});
