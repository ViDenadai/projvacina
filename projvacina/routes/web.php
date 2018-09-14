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

Route::group(['prefix' => 'painel'],function(){
     Route::get('vacinas', 'painel\VacinaController@index');
     
     Route::get('permissions', 'painel\PermissionController@index');
     Route::get('roles', 'painel\RoleController@index');
     Route::get('role/{id}/permissions', 'painel\RoleController@permissions');
     Route::get('users', 'painel\UserController@index');
     Route::get('/', 'painel\PainelController@index');
     Route::get('newpermission', 'painel\PermissionController@new');
     Route::get('newfunction', 'painel\UserController@newfunction');
     Route::get('newvacina', 'painel\VacinaController@new');

});



Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'painel\PainelController@index');
Route::get('home', 'painel\PainelController@index');
Route::resource('users','painel\UserController');
Route::resource('painel','painel\PainelController');
Route::resource('caddose','DoseController');
Route::resource('carteira','HomeController');
Route::resource('newfunctions','painel\UserController');
