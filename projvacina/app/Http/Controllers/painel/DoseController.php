<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Dose;
use App\User;

class DoseController extends Controller
{
    private $dose;
    
    public function __construct(dose $doses)
    {
        $this->dose = $doses;
        // referencia a tabela dose        
    }
    
    // Se há alguma mensagem de sucesso ela é passada à view
    public function index($successMsg = null)
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
        }

        // Recupera as doses do usuário logado
        $myDoses = DB::table('doses')
                    ->join('users', 'doses.id_user', '=', 'users.id')
                    ->join('vaccines', 'doses.vaccine_id', '=', 'vaccines.id')
                    ->select('doses.*', 'users.name as user_name', 'vaccines.name as vaccine_name')
                    ->where('id_user', $user->id)
                    ->get();

        // Formatação de data
        foreach ($myDoses as $myDose) {
            $myDose->validade = date_format(new \DateTime($myDose->validade), 'd/m/Y'); 
        } 

        // Tipo do usuário (1 - adm; 2 - usuário comum; 3 - profissional da saúde)
        $userType = (DB::table('role_user')
                        ->join('users', 'role_user.user_id', '=', 'users.id')
                        ->select('role_id')
                        ->where('user_id', $user->id)
                        ->first())->role_id;
                        
        // painel.Vacinas.index => view da carteira de vacinação com todas as doses
        return view('painel.Vacinas.index', compact('doses', 'myDoses', 'patientsName', 'userType' , 'successMsg'));
    }

    public function update(Request $request)
    {
        $dose = Dose::findOrFail($request->idDose);            
        if( Gate::denies('update-dose', $dose) )
                abort(403, 'Unauthorized');

        
        // $dose->save();

        // Após o tipo de vacina ser atualizado
        // retorna para a página de tipos de vacinas por meio do index
        // com uma mensagem de confirmação
        $successMsg = 'Tipo de vacina atualizado com sucesso!'; 
        return $this->index($successMsg); 
    }

    // public function new() 
    // {
    //     return view('include-dose');
    //     // retorna view para inserir uma nova dose na tabela
    // }

    public function store(Request $request)
    {
        $dose = new dose;
        $dose->nome = $request->nome;
        $dose->local = $request->local;
        $dose->id_user = (DB::table('users')->select('id')->where('name', '=', $request->patientSelectName)->first())->id;
        $dose->numerodose = $request->numerodose;
        $dose->validade = $request->validade;
        $dose->save();
        $successMsg = 'Dose adicionada com sucesso!'; 
        return $this->index($successMsg);      
    }

    // Função que recebe no parâmetro o id da dose a ser removida da tabela
    public function destroy(Request $request) 
    {
        $dose = Dose::findOrFail($request->doseId);
        $dose->delete();

        // Após a dose ser removida 
        // retorna para a página de doses por meio do index
        // com uma mensagem de confirmação
        $successMsg = 'Dose removida com sucesso!';
        return $this->index($successMsg);      
    }
    
}
