<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permission;

class PermissionController extends Controller
{ 
    private $permission;
    
    public function __construct(permission $permissions)
    {
        $this->permission = $permissions;        
    }
    
    public function index()
    {
        $permissions = $this->permission->all();
        //abort(403, 'Not Permissions Lists Post');      

        return view('painel.permissions.index', compact('permissions'));
    }
    
    public function new() 
    {       
        return view('Painel.permissions.new');
    }
}
