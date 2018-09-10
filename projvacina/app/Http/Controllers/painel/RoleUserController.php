<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permission;
use App\role_user;

class PermissionController extends Controller
{ private $permission;
    
    public function __construct(permission $permissions)
    {
        $this->permission = $permissions;
        
        
    }
    
    public function index()
    {
       
        
        return view('newfunction');
    }
    
    public function new(Request $request) {
        $roleuser = new roleuser;
        $roleuser->user_id = $request->user_id;
        $roleuser->role_id = $request->role_id;
       
        $roleuser->save();
       
        return view('newfunction', compact('roleuser'))->with('successMsg','Property is updated .');
       
    }

}
