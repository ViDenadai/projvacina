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
// aqui temos as rotas que possuem como prefixo /painel
Route::group(['prefix' => 'painel', 'as' => 'painel.'], function(){
    //  rota que direciona para a função index do controller painel,pagina inicial
    Route::get('/', 'painel\PainelController@index');

    //  rota que direciona para a função index do controller users 
    Route::get('users', 'painel\UserController@index');
    
    //  rota que direciona para a função index do controller Dose
    Route::get('doses', ['as' => 'doses', 'uses' => 'painel\DoseController@index']);
    //  Rota que direciona para a função store do controller Dose
    Route::post('storeDose', ['as' => 'storeDose', 'uses' => 'painel\DoseController@store']);
    //  Rota que direciona para a função update do controller Dose
    Route::post('updateDose', ['as' => 'updateDose', 'uses' => 'painel\DoseController@update']);
    //  rota que direciona para a função destroy do controller Dose
    Route::post('deleteDose', ['as' => 'deleteDose', 'uses' => 'painel\DoseController@destroy']);

    //  rota que direciona para a função index do controller Vaccine
    Route::get('vaccines', ['as' => 'vaccines', 'uses' => 'painel\VaccineController@index']);
    //  rota para a requisição ajax de update do tipo de vacina
    Route::get('updateVaccine_ajax', ['as' => 'updateVaccine_ajax', 'uses' => 'painel\VaccineController@update_ajax']);
    //  Rota que direciona para a função store do controller Vaccine
    Route::post('storeVaccine', ['as' => 'storeVaccine', 'uses' => 'painel\VaccineController@store']);
    //  Rota que direciona para a função update do controller Dose
    Route::post('updateVaccine', ['as' => 'updateVaccine', 'uses' => 'painel\VaccineController@update']);
    //  rota que direciona para a função destroy do controller Vaccine
    Route::post('deleteVaccine', ['as' => 'deleteVaccine', 'uses' => 'painel\VaccineController@destroy']);

    //  rota que direciona para a função index do controller permission
    Route::get('permissions', 'painel\PermissionController@index');
    //  rota que direciona para a função new do controller Permission
    Route::get('newpermission', 'painel\PermissionController@new');

    //  rota que direciona para a função index do controller roles são as funções presentes no sistema
    Route::get('roles', 'painel\RoleController@index');   
    //  rota que direciona para a função permissions do controller roles onde mostra as permissões atribuidas para cada função
    Route::get('role/{id}/permissions', 'painel\RoleController@permissions');
      
    //  Rota que direciona para a função new do controller RoleUser
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

// rota que direciona para a função index do controller de doses
// Route::resource('dose','painel\DoseController');

// rota que direciona para a função index do controller painel é a pagina que entra logo após o usuario logar no sistema
Route::resource('painel','painel\PainelController');
Route::resource('carteira','HomeController');
Route::resource('funcoes','RoleUserController');

