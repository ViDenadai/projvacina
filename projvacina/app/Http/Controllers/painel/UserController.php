<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role_user;


class UserController extends Controller
{ private $user;
    
    public function __construct(user $users)
    {
        $this->user = $users;
    }
    
    public function index()
    {
        $users = $this->user->all();
            //abort(403, 'Not Permissions Lists Post');
        
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

