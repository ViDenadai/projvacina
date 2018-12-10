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

    public function newfunction()
    {        
        return view('newfunction');
    }

    public function store(Request $request) 
    {        
        // dd($request);
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
        $vaccineId = Input::get('vaccineId');
        $vaccine = Vaccine::findOrFail($vaccineId); 
        return response()->json(array('vaccine' => $vaccine));  
    }

    public function update(Request $request)
    {
        $dose = Dose::findOrFail($request->doseIdUpdate); 
        $dose->vaccine_id = $request->vaccineNameSelectUpdate;
        $dose->local = $request->localUpdate;
        $dose->id_user = (DB::table('users')->select('id')->where('name', '=', $request->patientSelectNameUpdate)->first())->id;
        
        // Em numerodose permanecem apenas os números
        $dose->numerodose = filter_var($request->doseSelectUpdate, FILTER_SANITIZE_NUMBER_INT);
        $dose->validade = $request->dateUpdate;
        $dose->save();

        // Após a dose ser atualizada
        // retorna para a página de doses por meio do index
        // com uma mensagem de confirmação
        $successMsg = 'Dose atualizada com sucesso!'; 
        return redirect()->action(
            'painel\DoseController@index', ['successMsg' => $successMsg]
        );  
    }
    
    public function edit($id) 
    {
        $users = user::findOrFail($id);
        return view('/painel', compact('users'));
    }

    public function destroy(Request $request) 
    {
        // Deleta o usuário
        $user = User::findOrFail($request->userId);
        $user->delete();

        // Deleta o tipo de usuário relacionado
        $role_user = DB::table('role_user')->where('user_id', '=', $user->id)->first();
        $role_user = Role_user::findOrFail($role_user->id);
        $role_user->delete();

        // Deleta as doses relacionadas
        $doses = DB::table('doses')->where('id_user', '=', $user->id)->get();
        foreach ($doses as $dose) {
            $dose = Dose::findOrFail($dose->id);
            $dose->delete();
        }

        // Após o usuário ser excluído
        // retorna para a página de usuários por meio do index
        // com uma mensagem de confirmação
        $successMsg = 'Usuário excluído com sucesso!'; 
        return redirect()->action(
            'painel\UserController@index', ['successMsg' => $successMsg]
        );          
    }

}

