<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\dose;

class DoseController extends Controller
{
    public function index() {
       
        return view('include-dose');
    }

    public function create() {
        return view('include-dose');
    }

    public function store(Request $request) {
        $dose = new dose;
        $dose->nome = $request->nome;
        $dose->local = $request->local;
        $dose->id_user = $request->id_user;
        $dose->numerodose = $request->numerodose;
        $dose->validade = $request->validade;
        $dose->save();
       
        return view('include-dose', compact('dose'))->with('successMsg','Property is updated .');
       
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        $dosess = Produto::findOrFail($id);
        return view('alter-dose', compact('dosess'));
    }

    public function update(Request $request, $id) {
        $dosess = Produto::findOrFail($id); 
        $dosess->name = $request->name;
        $dosess->description = $request->description;
        $dosess->quantity = $request->quantity;
        $dosess->price = $request->price;
        $dosess->save();
        return redirect()->route('dosess.index')->with('message', 'Produto alterado com sucesso!');
    }

    public function destroy($id) {
        $dosess = dose::findOrFail($id);
        $dosess->delete();
        return redirect()->route('dosess.index')->with('message', 'Produto excluído com sucesso!');
    }

}
