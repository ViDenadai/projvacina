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
    // aqui temos as rotas que possuem como prefixo /painel
    Route::get('vacinas', 'painel\VacinaController@index');

    //  rota que direciona para a função index do controller vacina 
    Route::get('vacinasdelete', 'painel\VacinaController@destroy');

    //  rota que direciona para a função destroy do controller de vacinas
    Route::get('permissions', 'painel\PermissionController@index');

    //  rota que direciona para a função index do controller permission
    Route::get('roles', 'painel\RoleController@index');

    //  rota que direciona para a função index do controller roles são as funções presentes no sistema
    Route::get('role/{id}/permissions', 'painel\RoleController@permissions');

    //  rota que direciona para a função permissions do controller roles onde mostra as permissões atribuidas para cada função
    Route::get('users', 'painel\UserController@index');

    //  rota que direciona para a função index do controller users 
    Route::get('/', 'painel\PainelController@index');

    //  rota que direciona para a função index do controller painel,pagina inicial 
    Route::get('newpermission', 'painel\PermissionController@new');

    //  rota que direciona para a função new do controller Vacina 
    Route::get('newvacina', 'painel\VacinaController@new');

    //  rota que direciona para a função store do controller Vacina
    Route::post('storeVaccine', 'painel\VacinaController@store');

    //  rota que direciona para a função new do controller vacina 
    Route::get('newfunction','painel\RoleUserController@newfunction');
});



Route::get('/', function () {
    // Essa rota é a inicial direciona para a tela incial
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'painel\PainelController@index');
Route::get('home', 'painel\PainelController@index');

// rota que direciona para a função index do controller do usuario
Route::resource('users','painel\UserController');

// rota que direciona para a função index do controller de vacinas
Route::resource('vacinas','painel\VacinaController');

// rota que direciona para a função index do controller painel é a pagina que entra logo após o usuario logar no sistema
Route::resource('painel','painel\PainelController');
Route::resource('carteira','HomeController');
Route::resource('funcoes','RoleUserController');

