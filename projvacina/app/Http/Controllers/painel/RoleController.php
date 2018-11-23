<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;

class RoleController extends Controller
{
    private $role;
    
    public function __construct(role $roles)
    {
        $this->role = $roles;
        
        
    }
    
    public function index()
    {
        $roles = $this->role->all();
            //abort(403, 'Not Permissions Lists Post');
        
        return view('painel.roles.index', compact('roles'));
    }
    public function permissions($id)
    {
        //Recupera o role
        $role = $this->role->find($id);
        
        //recuperar permissões
        $permissions = $role->permissions()->get();
        
        return view('painel.roles.permissions', compact('role', 'permissions'));
    }
}
