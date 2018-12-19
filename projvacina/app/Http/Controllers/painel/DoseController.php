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
        $this->middleware('auth');
        $this->dose = $doses;
        // referencia a tabela dose        
    }

    public function index()
    {
        // Se há uma mensagem de sucesso
        if (!empty(Input::get('successMsg'))) {
            $successMsg = Input::get('successMsg');
        }

        // Usuário logado
        $user = Auth::user();

        // Nome dos pacientes existentes na plataforma
        $patientsName = DB::table('users')->select('name')->get();
        if ($user->hasAnyRoles('adm')) {
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
        if (!$maxDoseNumber) {        
            $maxDoseNumber = 4;
        } else {
            if ($maxDoseNumber->numerodose < 4) {
                $maxDoseNumber = 4;
            } else {
                // A próxima dose será 1 unidade maior que o valor anterior
                $maxDoseNumber = intval($maxDoseNumber->numerodose) + 1;  
            }            
        }        
        // Formatação para a carteira de vacinação do usuário
        foreach ($vaccinesName as $vaccineName) {
            // Recupera as doses da vacina atual do usuário logado
            $myDoses = DB::table('doses')
                            ->join('users', 'doses.id_user', '=', 'users.id')
                            ->join('vaccines', 'doses.vaccine_id', '=', 'vaccines.id')
                            ->select('doses.*')
                            ->where('doses.id_user', $user->id)
                            ->where('vaccines.name', $vaccineName->name)
                            ->get();

            // Loop para construção da tabela de doses
            for ($i = 0; $i < $maxDoseNumber; $i++) {
                if (!empty($myDoses[$i])) {
                    $myDosesTable[$vaccineName->name][$i]['validity'] = date_format(new \DateTime($myDoses[$i]->validade), 'd/m/Y');
                    $myDosesTable[$vaccineName->name][$i]['place'] = $myDoses[$i]->local;
                } else {
                    $myDosesTable[$vaccineName->name][$i]['validity'] = '';
                    $myDosesTable[$vaccineName->name][$i]['place'] = '';
                }
            }            
        }

        // Primeiro número de dose presente na adição de uma nova dose
        // depende do primeiro valor no select de nome de paciente 
        // e do primeiro valor no select de nome de vacina
        $firstDoseValue = DB::table('doses')
                            ->join('users', 'doses.id_user', '=', 'users.id')
                            ->select('doses.*', 'users.name as patientName')
                            ->where('vaccine_id', '=', $vaccinesName[0]->id)
                            ->where('users.name', '=', $patientsName[0]->name)
                            ->orderBy('numerodose', 'desc')
                            ->first();

        // Se o paciente não tomou nenhuma dose da vacina
        // o valor de $doseNumber será null, logo,
        // será a 1ª
        if(!$firstDoseValue){
            $firstDoseValue = "1";
        } else {
            // A próxima dose será 1 unidade maior que o valor anterior
            $firstDoseValue = strval(intval($firstDoseValue->numerodose) + 1);
        }
        
        // Quantidade de vacinas existentes
        $vaccineNumber = count($vaccinesName);
        
        // painel.Vacinas.index => view da carteira de vacinação com todas as doses
        return view('painel.doses.index', compact(
                                                'doses', 
                                                'myDoses', 
                                                'patientsName', 
                                                'userType' , 
                                                'successMsg', 
                                                'vaccinesName',
                                                'firstDoseValue',
                                                'myDosesTable',
                                                'maxDoseNumber',
                                                'vaccineNumber'));
    }

    public function addDose_ajax()
    {
        // Id do nome da vacina selecionada
        $vaccine_id = Input::get('vaccineId');
        // Nome do paciente
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
        
        // Em numerodose permanecem apenas os números
        $dose->numerodose = filter_var($request->numerodose, FILTER_SANITIZE_NUMBER_INT);
        $dose->validade = $request->validade;
        $dose->save();
        $successMsg = 'Dose adicionada com sucesso!'; 
        return redirect()->action(
            'painel\DoseController@index', ['successMsg' => $successMsg]
        ); 
    }

    // Função que retorna os dados necessários para
    // a atualização da dose
    public function update_ajax()
    {        
        // Id da dose selecionada
        $doseId = Input::get('doseId');

        // Dose correspondente
        $dose = DB::table('doses')
                    ->join('users', 'doses.id_user', '=', 'users.id')
                    ->select('doses.*', 'users.name as patientName')
                    ->where('doses.id', '=', $doseId)
                    ->first();
        return response()->json(array('dose' => $dose));  
    }

    public function updateDoseNumber_ajax(Request $request)
    {
        // Id da dose selecionada no update
        $doseId = Input::get('doseId');
        
        // Id do nome da vacina selecionada
        $vaccine_id = Input::get('vaccineId');

        // Nome do paciente
        $patientName = Input::get('patientName');

        // Números das doses existentes para a vacina e a pessoa
        // selecionada
        $doseNumbers =  DB::table('doses')
                            ->join('users', 'doses.id_user', '=', 'users.id')
                            ->select('doses.numerodose', 'doses.id')
                            ->where('vaccine_id', '=', $vaccine_id)
                            ->where('users.name', '=', $patientName)
                            ->orderBy('numerodose', 'asc')
                            ->distinct()
                            ->get();
                            
        // Doses podem possuir valores de 1 a 15(É a minha definição,
        // alterar aqui se mais números forem necessários)
        $doseNumbersPossibilities = range(1, 15);
        
        foreach ($doseNumbers as $doseNumber) {
            // O número da dose atual do registro é mantido entre as
            // possibilidades de seleção
            if ($doseNumber->id != $doseId) {
                unset($doseNumbersPossibilities[intval($doseNumber->numerodose)-1]);
            }
        }
        return response()->json(array('doseNumbersPossibilities' => $doseNumbersPossibilities)); 
    }

    public function update(Request $request)
    {
        $dose = Dose::findOrFail($request->doseIdUpdate); 
        $dose->vaccine_id = $request->vaccineNameSelectUpdate;
        $dose->local = $request->localUpdate;
        $dose->id_user = (DB::table('users')->select('id')->where('name', '=', $request->patientSelectNameUpdate)->first())->id;
        
        // Em numerodose permanecem apenas os números
        $dose->numerodose = filter_var($request->doseSelectUpdate, FILTER_SANITIZE_NUMBER_INT);
        $dose->validade = $request->dateUpdate;
        $dose->save();

        // Após a dose ser atualizada
        // retorna para a página de doses por meio do index
        // com uma mensagem de confirmação
        $successMsg = 'Dose atualizada com sucesso!'; 
        return redirect()->action(
            'painel\DoseController@index', ['successMsg' => $successMsg]
        );  
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
        return redirect()->action(
            'painel\DoseController@index', ['successMsg' => $successMsg]
        );     
    }
    
}
