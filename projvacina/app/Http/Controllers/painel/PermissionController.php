<?php

namespace App\Http\Controllers\painel;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Controller;
use App\Permission;

class PermissionController extends Controller
{ 
    private $permission;
    
    public function __construct(Permission $permissions)
    {
        $this->middleware('auth');
        $this->permission = $permissions;        
    }
    
    public function index()
    {
        // Se há uma mensagem de sucesso
        if (!empty(Input::get('successMsg'))) {
            $successMsg = Input::get('successMsg');
        }

        $permissions =  DB::table('permissions')
                            ->get();  

        return view('painel.permissions.index', compact('permissions', 'successMsg'));
    }
}
