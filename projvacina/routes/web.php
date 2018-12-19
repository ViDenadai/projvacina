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

// Rotas que possuem como prefixo /painel
Route::group(['prefix' => 'painel', 'as' => 'painel.', 'middleware' => ['auth']], function(){
    //  Rota que direciona para a função index do controller painel,pagina inicial
    // Route::get('/', 'painel\PainelController@index');

    //  Rota que direciona para a função index do controller User 
    Route::get('users', 'painel\UserController@index');
    //  Rota que direciona para a função store do controller User
    Route::post('storeUser', ['as' => 'storeUser', 'uses' => 'painel\UserController@store']);
    //  rota para a requisição ajax de update de usuário
    Route::get('updateUser_ajax', ['as' => 'updateUser_ajax', 'uses' => 'painel\UserController@updateUser_ajax']);
    //  Rota que direciona para a função update do controller User
    Route::post('updateUser', ['as' => 'updateUser', 'uses' => 'painel\UserController@update']);
    //  rota que direciona para a função destroy do controller User
    Route::post('deleteUser', ['as' => 'deleteUser', 'uses' => 'painel\UserController@destroy']);
    
    //  rota que direciona para a função index do controller Dose
    Route::get('doses', ['as' => 'doses', 'uses' => 'painel\DoseController@index']);
    //  rota para a requisição ajax de adição de dose
    Route::get('addDose_ajax', ['as' => 'addDose_ajax', 'uses' => 'painel\DoseController@addDose_ajax']);    
    //  Rota que direciona para a função store do controller Dose
    Route::post('storeDose', ['as' => 'storeDose', 'uses' => 'painel\DoseController@store']);

    //  rota que direciona para a função index do controller DoseManager
    Route::get('doseManager', ['as' => 'doseManager', 'uses' => 'painel\DoseManagerController@index']);
    //  rota para a requisição ajax de adição de dose
    Route::get('addDoseManager_ajax', ['as' => 'addDoseManager_ajax', 'uses' => 'painel\DoseManagerController@addDose_ajax']);    
    //  Rota que direciona para a função store do controller DoseManager
    Route::post('storeDoseManager', ['as' => 'storeDoseManager', 'uses' => 'painel\DoseManagerController@store']);
    //  rota para a requisição ajax de update de dose
    Route::get('updateDoseManager_ajax', ['as' => 'updateDoseManager_ajax', 'uses' => 'painel\DoseManagerController@update_ajax']);
    //  rota para a requisição ajax de update do número da dose
    Route::get('updateDoseManagerNumber_ajax', ['as' => 'updateDoseManagerNumber_ajax', 'uses' => 'painel\DoseManagerController@updateDoseNumber_ajax']);
    //  Rota que direciona para a função update do controller DoseManager
    Route::post('updateDoseManager', ['as' => 'updateDoseManager', 'uses' => 'painel\DoseManagerController@update']);
    //  rota que direciona para a função destroy do controller DoseManager
    Route::post('deleteDoseManager', ['as' => 'deleteDoseManager', 'uses' => 'painel\DoseManagerController@destroy']);

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

    //  rota que direciona para a função index do controller roles são as funções presentes no sistema
    Route::get('roles', 'painel\RoleController@index');   
    //  Rota que direciona para a função store do controller User
    Route::post('storeRole', ['as' => 'storeRole', 'uses' => 'painel\RoleController@store']);
    //  rota para a requisição ajax de update de usuário
    Route::get('updateRole_ajax', ['as' => 'updateRole_ajax', 'uses' => 'painel\RoleController@updateRole_ajax']);
    //  Rota que direciona para a função update do controller User
    Route::post('updateRole', ['as' => 'updateRole', 'uses' => 'painel\RoleController@update']);
    //  rota que direciona para a função destroy do controller User
    Route::post('deleteRole', ['as' => 'deleteRole', 'uses' => 'painel\RoleController@destroy']);

    //  rota que direciona para a função index do controller roles são as funções presentes no sistema
    // Route::get('permissions', 'painel\PermissionController@index');   
    // //  Rota que direciona para a função store do controller User
    // Route::post('storePermission', ['as' => 'storePermission', 'uses' => 'painel\PermissionController@store']);
    // //  rota para a requisição ajax de update de usuário
    // Route::get('updatePermission_ajax', ['as' => 'updatePermission_ajax', 'uses' => 'painel\PermissionController@updatePermission_ajax']);
    // //  Rota que direciona para a função update do controller User
    // Route::post('updatePermission', ['as' => 'updatePermission', 'uses' => 'painel\PermissionController@update']);
    // //  rota que direciona para a função destroy do controller User
    // Route::post('deletePermission', ['as' => 'deletePermission', 'uses' => 'painel\PermissionController@destroy']);

    // //  rota que direciona para a função index do controller permission
    // Route::get('permissions', 'painel\PermissionController@index');
    // //  rota que direciona para a função new do controller Permission
    // Route::get('newpermission', 'painel\PermissionController@new');
    
    // //  Rota que direciona para a função new do controller RoleUser
    // Route::get('newfunction','painel\RoleUserController@newfunction');
});

Route::get('/', function () {
    // Essa rota é a inicial direciona para a tela incial
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'painel\DoseController@index');
Route::get('home', 'painel\DoseController@index');

// Rota de registro de usuário
Route::post('userRegister', ['as' => 'userRegister', 'uses' => 'Auth\RegisterController@register']);

// Rota de logout
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

// Rota para verificação de e-mail na recuperação de senha
Route::get('forgotPass_email_ajax', ['as' => 'forgotPass_email_ajax', 'uses' => 'Auth\ForgotPasswordController@forgotPass_email_ajax']);

// rota que direciona para a função index do controller painel é a pagina que entra logo após o usuario logar no sistema
// Route::resource('painel','painel\PainelController');

