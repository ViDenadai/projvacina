<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Role_user;

class RoleUserController extends Controller
{     
    public function index()
    {               
        return view('newfunction');
    }
    
    public function newfunction()
    {
       
        
        return view('newfunction');
    }
    
    public function store(Request $request) {
        $role_user = new role_user;
        $role_user->user_id = $request->user_id;
        $role_user->role_id = $request->role_id;
       
        $role_user->save();
       
        return view('newfunction', compact('role_user'))->with('successMsg','Property is updated .');
       
    }

}
