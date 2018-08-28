<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

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
    //
}

