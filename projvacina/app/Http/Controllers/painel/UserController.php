<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Controller;
use App\User;
use App\Role_user;
use App\Dose;

class UserController extends Controller
{ 
    private $user;
    
    public function __construct(user $users)
    {
        $this->user = $users;
    }
    
    public function index()
    {
        // Se há uma mensagem de sucesso
        if (!empty(Input::get('successMsg'))) {
            $successMsg = Input::get('successMsg');
        }

        // Usuários do sistema junto com as suas funções
        $users = DB::table('users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->select('users.*', 'roles.name as role_name', 'roles.label as role_label')
                    ->get(); 

        // Funções
        $roles = DB::table('roles')
                    ->select('roles.name')
                    ->get();
        
        return view('painel.users.index', compact('users', 'roles', 'successMsg'));
    }

    public function store(Request $request) 
    {    
        // Persistência do usuário
        $user = new User;
        $user->name = $request->nameAdd;
        $user->email = $request->emailAdd;
        $user->password = Hash::make($request->passwordAdd);
        $user->nascimento = $request->birthDate;
        $user->save();

        // Persistência do tipo de usuário
        $role_user = new Role_user;
        $role_user->timestamps = false;
        $role_user->user_id = $user->id;
        $role_user->role_id = (DB::table('roles')->where('name', '=', $request->roleAddSelect)->first())->id;       
        $role_user->save(); 

        // Após o usuário ser adicionado
        // retorna para a página de usuários por meio do index
        // com uma mensagem de confirmação
        $successMsg = 'Usuário cadastrado com sucesso!'; 
        return redirect()->action(
            'painel\UserController@index', ['successMsg' => $successMsg]
        );     
    }

    public function updateUser_ajax()
    {
        // Id do nome da vacina selecionada
        $userId = Input::get('userId');
        $user = User::findOrFail($userId);
        
        $userRole = DB::table('role_user')
                        ->join('roles', 'role_user.role_id', '=', 'roles.id')
                        ->select('roles.name as role_name')
                        ->where('user_id', '=', $userId)
                        ->first();
        return response()->json(array('user' => $user, 'userRole' => $userRole));  
    }

    public function update(Request $request)
    {
        // Atualização do usuário
        $user = User::findOrFail($request->userIdUpdate);
        $user->name = $request->nameUpdate;
        $user->email = $request->emailUpdate;
        $user->password = Hash::make($request->passwordUpdate);
        $user->nascimento = $request->birthDateUpdate;
        $user->save();
        
        // Atualização do tipo de usuário
        $role_user = DB::table('role_user')
                        ->join('roles', 'role_user.role_id', '=', 'roles.id')
                        ->select('role_user.id')
                        ->where('user_id', '=', $user->id)
                        ->first();
        $role_user = Role_user::findOrFail($role_user->id);
        $role_user->timestamps = false;
        $role_user->role_id = (DB::table('roles')->where('name', '=', $request->roleUpdateSelect)->first())->id;
        $role_user->save(); 


        // Após o usuário ser atualizado
        // retorna para a página de usuários por meio do index
        // com uma mensagem de confirmação
        $successMsg = 'Usuário atualizado com sucesso!'; 
        return redirect()->action(
            'painel\UserController@index', ['successMsg' => $successMsg]
        );  
    }

    public function destroy(Request $request) 
    {
        // Atualiza os usários do perfil excluído para usuário comum(Altera a tabela role_user)
        $role_users =   DB::table('role_user')
                            ->select('id')
                            ->where('role_id', '=', $request->roleId)
                            ->get();
dd($role_users);
        // // Deleta o usuário
        // $user = User::findOrFail($request->userId);
        // $user->delete();

        // // Deleta o tipo de usuário relacionado
        // $role_user = DB::table('role_user')->where('user_id', '=', $user->id)->first();
        // $role_user = Role_user::findOrFail($role_user->id);
        // $role_user->delete();

        // // Deleta as doses relacionadas
        // $doses = DB::table('doses')->where('id_user', '=', $user->id)->get();
        // foreach ($doses as $dose) {
        //     $dose = Dose::findOrFail($dose->id);
        //     $dose->delete();
        // }

        // // Após o usuário ser excluído
        // // retorna para a página de usuários por meio do index
        // // com uma mensagem de confirmação
        // $successMsg = 'Usuário excluído com sucesso!'; 
        // return redirect()->action(
        //     'painel\UserController@index', ['successMsg' => $successMsg]
        // );          
    }

}

