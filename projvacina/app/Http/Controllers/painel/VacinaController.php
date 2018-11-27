<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
    
    public function index()
    {
        // Usuário logado
        $user = Auth::user();

        // Nome dos pacientes existentes na plataforma
        $patientsName = DB::table('users')->select('name')->get();
        if( $user->hasAnyRoles('adm') ){
            // Recupera todas as informações de doses junto com os nomes dos usuários correspondentes 
            $doses = DB::table('doses')
                        ->join('users', 'doses.id_user', '=', 'users.id')
                        ->join('vaccines', 'doses.vaccine_id', '=', 'vaccines.id')
                        ->select('doses.*', 'users.name as user_name', 'vaccines.name as vaccine_name')
                        ->get();

            // Formatação de data
            foreach ($doses as $dose) {
                $dose->validade = date_format(new \DateTime($dose->validade), 'd/m/Y'); 
            }
        } else {
            // Recupera todas as informações de doses junto com o nome do usuário correspondente 
            $doses = DB::table('doses')
                        ->join('users', 'doses.id_user', '=', 'users.id')
                        ->join('vaccines', 'doses.vaccine_id', '=', 'vaccines.id')
                        ->select('doses.*', 'users.name as user_name', 'vaccines.name as vaccine_name')
                        ->where('id_user', $user->id)
                        ->get();

            // Formatação de data
            foreach ($doses as $dose) {
                $dose->validade = date_format(new \DateTime($dose->validade), 'd/m/Y'); 
            }          
        }

        // Tipo do usuário (1 - adm; 2 - usuário comum; 3 - profissional da saúde)
        $userType = (DB::table('role_user')
                        ->join('users', 'role_user.user_id', '=', 'users.id')
                        ->select('role_id')
                        ->where('user_id', $user->id)
                        ->first())->role_id;

        // painel.Vacinas.index => view da carteira de vacinação com todas as doses
        return view('painel.Vacinas.index', compact('doses', 'patientsName', 'userType'));
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

    public function store(Request $request)
    {
        $dose = new dose;
        $dose->nome = $request->nome;
        $dose->local = $request->local;
        $dose->id_user = (DB::table('users')->select('id')->where('name', '=', $request->patientSelectName)->first())->id;
        $dose->numerodose = $request->numerodose;
        $dose->validade = $request->validade;
        $dose->save(); 
        $this->index();
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
