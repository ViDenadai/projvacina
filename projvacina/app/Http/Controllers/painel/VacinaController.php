<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\dose;

class VacinaController extends Controller
{
    private $dose;
    
    public function __construct(dose $doses)
    {
        $this->dose = $doses;
        
        
    }
    
    public function index()
    {
        $doses = $this->dose->all();
            //abort(403, 'Not Permissions Lists Post');
        
        return view('painel.Vacinas.index', compact('doses'));
    }
    //
}
