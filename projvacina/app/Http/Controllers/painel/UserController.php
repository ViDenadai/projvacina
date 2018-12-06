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
        $users = DB::table('users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->select('users.*', 'roles.name as role_name', 'roles.label as role_label')
                    ->get(); 
        return view('painel.users.index', compact('users'));
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

