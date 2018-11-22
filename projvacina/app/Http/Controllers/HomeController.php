<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Dose;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(dose $dose)
    {
        $doses=$dose->where('id_user',auth()->user()->id)->get();
        return view('home',compact('doses'));
    }
    public function update($iddose)
    {
        $dose = Dose::find($iddose);
        
       
        if( Gate::denies('update-dose', $dose) )
                abort(403, 'Unauthorized');
        
        return view('dose-update', compact('dose'));
    }
    public function inicio()
    {
        
        return view('welcome');
    }
}
