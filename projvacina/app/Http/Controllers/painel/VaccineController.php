<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Controller;
use App\Vaccine;

class VaccineController extends Controller
{
    private $vaccine;
    
    /**
     *
     * Construtor
     *
     * @param    Vaccine  $vaccine
     *
     */
    public function __construct(Vaccine $vaccine)
    {
        $this->middleware('auth');
        // referencia a tabela vacine
        $this->vaccine = $vaccine;                
    }
    
    /**
     *
     * Função index
     *
     * @param    string     $successMsg     Mensagem de sucesso de alguma operação
     * @return   array      $vaccines       Vetor contendo todos os tipos de vacina
     *
     */
    public function index($successMsg = null)
    {
        // Recupera os tipos de vacina
        $vaccines = DB::table('vaccines')
                        ->get();

        // painel.vaccinesTypes.index => view com todos os nomes de vacinas possíveis
        return view('painel.vaccinesTypes.index', compact('vaccines', 'successMsg'));
    }

    /**
     *
     * Função de atualização do tipo de vacina
     *
     * @param    Request     $request           Contém as informações do novo registro
     * @return   string      $successMsg        Mensagem de sucesso da atualização
     *
     */
    public function store(Request $request)
    {
        $vaccine = new Vaccine;

        // É necessário setar o timestamps para false,
        // já que a tabela não possui timestamps
        $vaccine->timestamps = false;
        $vaccine->name = $request->nameAdd;
        $vaccine->save();
        
        // Após o tipo de vacina ser adicionado 
        // retorna para a página de tipos de vacinas por meio do index
        // com uma mensagem de confirmação
        $successMsg = 'Tipo de vacina adicionado com sucesso!'; 
        return $this->index($successMsg);    
    }

    /**
     *
     * Função que recupera as informações do tipo de vacina para atualização
     *
     * @return   array      $vaccine        Vetor contendo o tipo de vacina
     *
     */
    public function update_ajax()
    {
        // Id do nome da vacina selecionada
        $vaccineId = Input::get('vaccineId');
        $vaccine = Vaccine::findOrFail($vaccineId); 
        return response()->json(array('vaccine' => $vaccine));  
    }

    /**
     *
     * Função de atualização do tipo de vacina
     *
     * @param    Request     $request           Contém o id do tipo de vacina a ser manipulado
     * @return   string      $successMsg        Mensagem de sucesso da atualização
     *
     */
    public function update(Request $request)
    {
        $vaccine = Vaccine::findOrFail($request->vaccineIdUpdate); 
        
        // É necessário setar o timestamps para false,
        // já que a tabela não possui timestamps
        $vaccine->timestamps = false;
        $vaccine->name = $request->nameUpdate;
        $vaccine->save();

        // Após o tipo de vacina ser atualizado
        // retorna para a página de tipos de vacinas por meio do index
        // com uma mensagem de confirmação
        $successMsg = 'Tipo de vacina atualizado com sucesso!'; 
        return $this->index($successMsg);  
    }
    
    /**
     *
     * Função de remoção do tipo de vacina
     *
     * @param    Request     $request           Contém o id do tipo de vacina a ser manipulado
     * @return   string      $successMsg        Mensagem de sucesso da atualização
     *
     */
    public function destroy(Request $request) 
    {
        $vaccine = Vaccine::findOrFail($request->vaccineId);
        $vaccine->delete();

        // Após o tipo de vacina ser removido 
        // retorna para a página de tipos de vacinas por meio do index
        // com uma mensagem de confirmação
        $successMsg = 'Tipo de vacina removido com sucesso!'; 
        return $this->index($successMsg);        
    }
    
}
