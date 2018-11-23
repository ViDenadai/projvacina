<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Dose;
use App\User;

class VacinaController extends Controller
{
    private $dose;
    
    public function __construct(dose $doses)
    {
        $this->dose = $doses;
        // referencia a tabela dose        
    }
    
    public function index(user $user,dose $dose)
    {
        if( $user->hasAnyRoles('adm') ){
            // Todas as informações de doses junto com os nomes dos usuários correspondentes 
            $doses = DB::table('doses')
                        ->join('users', 'doses.id_user', '=', 'users.id')
                        ->select('doses.*', 'users.name')
                        ->get();
            return view('painel.Vacinas.index', compact('doses'));
        } else {
            // Todas as informações de doses junto com o nome do usuário correspondente 
            $doses = DB::table('doses')
                        ->join('users', 'doses.id_user', '=', 'users.id')
                        ->select('doses.*', 'users.name as user_name')
                        ->where('id_user', auth()->user()->id)
                        ->get();
            return view('painel.Vacinas.index', compact('doses'));
            // painel.Vacinas.index => view da carteira de vacinação com todas as doses
        }
    }

    public function update($iddose)
    {
        $dose = Dose::find($iddose);            
        if( Gate::denies('update-dose', $dose) )
                abort(403, 'Unauthorized');
        
        return view('dose-update', compact('dose'));
    }

    public function new() 
    {
        return view('include-dose');
        // retorna view para inserir uma nova dose na tabela
    }

    public function destroy($id) 
    {
        // função que recebe como parametro o id da vacina para ser removida da tabela
        $dose = dose::findOrFail($id);
        $dose->delete();
        return redirect('painel/vacinas')->with('successMsg', 'Dose removida com sucesso!');
        // após a dose ser removida retorna para a pagina de vacinas com uma mensagem de confirmação
    }
    
}
