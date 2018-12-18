<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permission;
use App\Role_user;
use App\User;

class RoleUserController extends Controller
{ private $role_user;
   
    
    public function __construct(permission $role_users)
    {
        $this->middleware('auth');
        $this->role_user = $role_users;                
    }
    
   
    public function index()
    {
       
        
        return view('newfunction');
    }
    public function newfunction()
    {
        
        
        
        return view('newfunction');
    }
    
    public function new(Request $request) {
        $roleusers = new roleuser;
        $roleusers->user_id = $request->user_id;
        $roleusers->role_id = $request->role_id;
       
        $roleusers->save();
       
        return view('newfunction', compact('roleuser'))->with('successMsg','Property is updated .');
       
    }

}
