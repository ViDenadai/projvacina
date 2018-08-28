<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Permission;
use App\dose;
class PainelController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalRoles = Role::count();
        $totalPermissions =Permission::count();
        $totalPosts = dose::count();
        
        return view('painel.home.index', compact('totalUsers', 'totalRoles', 'totalPermissions', 'totalPosts'));
    }
}
