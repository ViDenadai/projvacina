<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Controller;
use App\User;
use App\Role_user;


class UserController extends Controller
{ 
    private $user;
    
    public function __construct(user $users)
    {
        $this->user = $users;
    }
    
    public function index()
    {
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
        
        return view('painel.users.index', compact('users', 'roles'));
    }

    public function newfunction()
    {        
        return view('newfunction');
    }

    public function store(Request $request) 
    {        
        $role_user = new role_user;
        $role_user->user_id = $request->user_id;
        $role_user->role_id = $request->role_id;       
        $role_user->save(); 
        return view('newfunction', compact('role_user'))->with('successMsg','Property is updated .');       
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

    public function destroy($id) 
    {
        $users = user::findOrFail($id);
        $users->delete();
        return redirect()->route('painel/users')->with('message', 'Produto excluído com sucesso!');   
    }

}

