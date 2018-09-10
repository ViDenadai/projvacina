<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\dose;
use App\User;

class VacinaController extends Controller
{
    private $dose;
    
    public function __construct(dose $doses)
    {
        $this->dose = $doses;
        
        
    }
    
   
    public function index(user $user,dose $dose)
    {
        if( $user->hasAnyRoles('adm') ){
        $doses = $this->dose->all();
        return view('painel.Vacinas.index', compact('doses'));}
else
        $doses=$dose->where('id_user',auth()->user()->id)->get();
        return view('painel.Vacinas.index',compact('doses'));
    }
    public function update($iddose)
    {
        $dose = Dose::find($iddose);
        
       
        if( Gate::denies('update-dose', $dose) )
                abort(403, 'Unauthorized');
        
        return view('dose-update', compact('dose'));
    }
    public function new() {
        return view('include-dose');
    }
    //
}
