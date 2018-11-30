<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


use App\Http\Controllers\Controller;
use App\Dose;
use App\User;
use App\Vaccine;

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
        // Tipo do usuário (1 - adm; 2 - usuário comum; 3 - profissional da saúde)
        $userType = (DB::table('role_user')
                        ->join('users', 'role_user.user_id', '=', 'users.id')
                        ->select('role_id')
                        ->where('user_id', $user->id)
                        ->first())->role_id;
        
        // Nome das vacinas existentes na plataforma
        $vaccinesName = DB::table('vaccines')->orderBy('name', 'asc')->get();

        // Inicialização do array de tabela de vacinação 
        $myDosesTable = [];

        // Maior número da dose entre as vacinas que o usuário tomou,         
        $maxDoseNumber = DB::table('doses')
                            ->join('users', 'doses.id_user', '=', 'users.id')
                            ->select('doses.*', 'users.name as patientName')
                            ->where('doses.id_user', $user->id)
                            ->orderBy('numerodose', 'desc')
                            ->first();

        // * Se $maxDoseNumber é null, o usuário não possui nenhum registro 
        // na plataforma
        // * Se esse valor for menor do que 4, o valor mínimo é posto
        // como 4, caso contrário, o valor será 1 unidade maior que esse
        // máximo
        if(!$maxDoseNumber){        
            $maxDoseNumber = 4;
        } else {
            if($maxDoseNumber->numerodose < 4) {
                $maxDoseNumber = 4;
            } else {
                // A próxima dose será 1 unidade maior que o valor anterior
                $maxDoseNumber = intval($maxDoseNumber->numerodose) + 1;  
            }            
        }
        dd($maxDoseNumber);
        // Formatação para a carteira de vacinação do usuário
        foreach ($vaccinesName as $vaccineName) {
            // Recupera as doses da vacina atual do usuário logado
            $myDoses = DB::table('doses')
                            ->join('users', 'doses.id_user', '=', 'users.id')
                            ->join('vaccines', 'doses.vaccine_id', '=', 'vaccines.id')
                            ->select('doses.*')
                            ->where('doses.id_user', $user->id)
                            ->where('vaccines.name', $vaccineName)
                            ->get();
            // Formatação de data
            foreach ($myDoses as $myDose) {
                $myDose->validade = date_format(new \DateTime($myDose->validade), 'd/m/Y'); 
            } 
            
        }
        
        // painel.Vacinas.index => view da carteira de vacinação com todas as doses
        return view('painel.Vacinas.index', compact(
                                                'doses', 
                                                'myDoses', 
                                                'patientsName', 
                                                'userType' , 
                                                'successMsg', 
                                                'vaccinesName'));
    }

    public function update(Request $request)
    {
        // $dose = Dose::findOrFail($request->idDose);            
        // if( Gate::denies('update-dose', $dose) )
        //         abort(403, 'Unauthorized');

        
        // // $dose->save();

        // // Após o tipo de vacina ser atualizado
        // // retorna para a página de tipos de vacinas por meio do index
        // // com uma mensagem de confirmação
        // $successMsg = 'Tipo de vacina atualizado com sucesso!'; 
        // return $this->index($successMsg); 
    }
    
    public function addDose_ajax()
    {
        // Id do nome da vacina selecionada
        // dd(Input::get('patientName'));
        $vaccine_id = Input::get('vaccineId');
        $patientName = Input::get('patientName');
        // Recupera o número da última dose tomada pelo paciente da vacina escolhida
        $doseNumber = DB::table('doses')
                        ->join('users', 'doses.id_user', '=', 'users.id')
                        ->select('doses.*', 'users.name as patientName')
                        ->where('vaccine_id', '=', $vaccine_id)
                        ->where('users.name', '=', $patientName)
                        ->orderBy('numerodose', 'desc')
                        ->first();
        // Se o paciente não tomou nenhuma dose da vacina
        // o valor de $doseNumber será null, logo,
        // será a 1ª
        if(!$doseNumber){
            $doseNumber = "1";
        } else {
            // A próxima dose será 1 unidade maior que o valor anterior
            $doseNumber = strval(intval($doseNumber->numerodose) + 1);
        }
        return response()->json(array('doseNumber' => $doseNumber));      
    }
    

    public function store(Request $request)
    {
        $dose = new Dose;
        $dose->vaccine_id = $request->vaccineNameSelect;
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
