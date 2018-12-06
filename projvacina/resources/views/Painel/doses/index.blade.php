@extends('painel.templates.template')

@section('content')
<div class="container">
    @if(!empty($successMsg))
    <div class="alert alert-success" role="alert"><i class="fas fa-check"></i> {{ $successMsg }} </div>
    @endif
    <br>
    <h1 class="title">
        <div class="d-flex">
            <div class="mr-auto p-2"><b>Minhas Vacinas</b></div>
            @if (Auth::user()->can('create_dose'))
                <div class="ml-auto p-2">
                    <a href="/painel/newDose" data-toggle="modal" data-target="#doseAddModal">
                        <b><i class="far fa-plus-square add"></i></b>
                    </a>  
                </div>
            @endif
        </div>
    </h1>
    <hr>
    <table id="myVaccineTable" class="table table-bordered myVaccineTable" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="10%" class="first-header-top-my-vaccine diagonal-line">                    
                    <span class="diagonal-sup">Vacinas</span>
                    <br>
                    <span class="diagonal-inf">Doses</span>                                       
                </th>
                @foreach($myDosesTable as $myDosesVaccineName => $myDoses)
                    <th class="headers-top-my-vaccine" width="(100/{{ $vaccineNumber }})%" style="text-align: center; vertical-align:middle;" scope="col">{{ $myDosesVaccineName }}</th>                    
                @endforeach
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < $maxDoseNumber; $i++)
                <tr>
                    <th class="headers-left-my-vaccine" style="text-align: center; vertical-align:middle" scope="row">{{$i + 1 }}ª Dose</th>
                    @foreach($myDosesTable as $$myDosesVaccineName => $myDoses)                       
                        @if($myDoses[$i]['validity'] != '' || $myDoses[$i]['place'] != '')
                            <td>
                                <div class="stamp">
                                    <div class="stamp-template">Validade </div> 
                                    
                                    {{ $myDoses[$i]['validity'] }}
                                    <br>
                                    <div class="stamp-template">Local  </div>  
                                    {{ $myDoses[$i]['place'] }} 
                                </div>
                            </td>
                        @else
                        <td>                            
                            <br>
                            <br>  
                            <br>
                            <br>                          
                        </td>
                        @endif
                    @endforeach                       
                </tr>
            @endfor
        </tbody>
    </table>

    <!-- Se o usuário for administrador ele pode ver todas as vacinas (1 - adm; 2 - usuário comum; 3 - profissional da saúde) -->
    @if ($userType == 1)
        <h1 class="title">
            <div class="d-flex">
                <div class="mr-auto p-2"><b>Todas as Vacinas</b></div>
                @if (Auth::user()->can('create_dose'))
                    <div class="ml-auto p-2">
                        <a href="/painel/newDose" data-toggle="modal" data-target="#doseAddModal">
                            <b><i class="far fa-plus-square add"></i></b>
                        </a>  
                    </div>
                @endif
            </div>
        </h1>
        <hr>
        <table id="vaccineTable" class="table table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Local</th>
                    <th>Dose</th>
                    <th>Validade</th>
                    <th>Nome do usuário</th>
                    @if (Auth::user()->can('edit_dose') || Auth::user()->can('delete_dose'))
                        <th width="100px">Ações</th>        
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($doses as $dose)
                    <tr>
                        <td>{{ $dose->vaccine_name }}</td>
                        <td>{{ $dose->local }}</td>
                        <td>{{ $dose->numerodose }}ª</td>
                        <td>{{ $dose->validade }}</td>
                        <td>{{ $dose->user_name }}</td>
                        <td> 
                        @if(Auth::user()->can('edit_dose'))
                            <a class="edit" href="#" title="Editar">
                                <i class="fa fa-pencil-square-o"></i>
                                <input type="hidden" class="doseId" id="doseId" name="doseId" value='{{ $dose->id }}'>
                            </a>
                        @endif
                        @if(Auth::user()->can('delete_dose'))
                            <form style="display: inline-block;" method="POST" 
                                action="{{route('painel.deleteDose')}}"                                                        
                                data-toggle="tooltip" data-placement="top"
                                title="Excluir" 
                                onsubmit="return confirm('Confirmar exclusão?')">
                                <input type="hidden" class="doseId" id="doseId" name="doseId" value='{{ $dose->id }}'>
                                {{-- method_field('DELETE') --}}{{ csrf_field() }}                                                
                                <button type="submit" class ="delete">
                                    <i class="fa fa-trash"></i>                                                    
                                </button>
                            </form>
                        @endif
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Modal de adição de doses -->
    <div class="modal fade" id="doseAddModal" role="dialog" aria-labelledby="doseAddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('painel.storeDose') }}" aria-label="{{ __('formDoseAdd') }}">
                    <!-- Modal header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar Dose</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <!-- CSRF protection -->
                        @csrf                        

                        <!-- Local da aplicação -->
                        <div class="form-group row">
                            <label for="local" class="col-md-4 col-form-label text-md-right">{{ __('Local da aplicação ') }}</label>
                            <div class="col-md-6">
                                <input id="local" 
                                    type="text" 
                                    class="form-control{{ $errors->has('local') ? ' is-invalid' : '' }}" 
                                    name="local" 
                                    value="{{ old('local') }}" 
                                    required>

                                @if ($errors->has('local'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('local') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Nome do paciente -->
                        <div class="form-group row">
                            <label for="id_user" class="col-md-4 col-form-label text-md-right">{{ __('Paciente') }}</label>
                            <div class="col-md-6">                                
                                <select id="patientSelectName" class="patientSelectName" name="patientSelectName" style="width: 100%" required></select>
                            </div>
                        </div>

                        <!-- Nome da vacina -->
                        <div class="form-group row">
                            <label for="nome" class="col-md-4 col-form-label text-md-right">{{ __('Nome da vacina') }}</label>
                            <div class="col-md-6">
                                <select id="vaccineNameSelect" class="vaccineNameSelect" name="vaccineNameSelect" style="width: 100%" required></select>
                            </div>
                        </div>

                        <!-- Número da Dose -->
                        <div class="form-group row">
                            <label for="numerodose" class="col-md-4 col-form-label text-md-right">{{ __('Número da dose') }}</label>

                            <div class="col-md-6">
                                <input  id="numerodose" 
                                        type="text" 
                                        class="form-control" 
                                        name="numerodose" 
                                        style="width: 11%" 
                                        value=  @if(!empty($firstDoseValue)) 
                                                    {{$firstDoseValue}}ª  
                                                @endif
                                        required 
                                        readonly>
                            </div>
                        </div>

                        <!-- Validade Dose -->
                        <div class="form-group row">
                            <label for="validade" class="col-md-4 col-form-label text-md-right">{{ __('Validade') }}</label>
                            <div class="col-md-6">
                                <input id="date" 
                                    type="date" 
                                    class="form-control{{ $errors->has('validade') ? ' is-invalid' : '' }}" 
                                    name="validade" 
                                    required>

                                @if ($errors->has('validade'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('validade') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>                                
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">{{ __('Adicionar') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de edição do tipo de vacina -->
    <div class="modal fade" id="doseUpdateModal" role="dialog" aria-labelledby="doseUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('painel.updateDose') }}" aria-label="{{ __('formUpdateDose') }}">
                    <!-- Modal header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUpdateLabel">Alterar informações da dose</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <!-- CSRF protection -->
                        @csrf                        

                        <!-- Local da aplicação -->
                        <div class="form-group row">
                            <label for="local" class="col-md-4 col-form-label text-md-right">{{ __('Local da aplicação ') }}</label>
                            <div class="col-md-6">
                                <input id="localUpdate" 
                                    type="text" 
                                    class="form-control{{ $errors->has('localUpdate') ? ' is-invalid' : '' }}" 
                                    name="localUpdate" 
                                    value="{{ old('localUpdate') }}" 
                                    required>

                                @if ($errors->has('local'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('localUpdate') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Nome do paciente -->
                        <div class="form-group row">
                            <label for="id_user" class="col-md-4 col-form-label text-md-right">{{ __('Paciente') }}</label>
                            <div class="col-md-6">                                
                                <select id="patientSelectNameUpdate" class="selectsUpdate" name="patientSelectNameUpdate" style="width: 100%" required></select>
                            </div>                            
                        </div>

                        <!-- Nome da vacina -->
                        <div class="form-group row">
                            <label for="nome" class="col-md-4 col-form-label text-md-right">{{ __('Nome da vacina') }}</label>
                            <div class="col-md-6">
                                <select id="vaccineNameSelectUpdate" class="selectsUpdate" name="vaccineNameSelectUpdate" style="width: 100%" required></select>
                            </div>
                        </div>

                        <!-- Número da Dose -->
                        <div class="form-group row">
                            <label for="numerodose" class="col-md-4 col-form-label text-md-right">{{ __('Números de doses disponíveis') }}</label>

                            <div class="col-md-6">
                                <select class="doseSelectUpdate" id="doseSelectUpdate" name="doseSelectUpdate" style="width: 15%" required></select>
                            </div>
                        </div>

                        <!-- Validade Dose -->
                        <div class="form-group row">
                            <label for="dateUpdate" class="col-md-4 col-form-label text-md-right">{{ __('Validade') }}</label>
                            <div class="col-md-6">
                                <input id="dateUpdate" 
                                    type="date" 
                                    class="form-control{{ $errors->has('dateUpdate') ? ' is-invalid' : '' }}" 
                                    name="dateUpdate" 
                                    required>

                                @if ($errors->has('dateUpdate'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('dateUpdate') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 

                        <!-- Id da dose para o update -->
                        <input type="hidden" class="doseIdUpdate" id="doseIdUpdate" name="doseIdUpdate" value=''>
                    </div>                                
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">{{ __('Alterar') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<!-- DataTable Bootstrap 4 -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
<!-- DataTable Js Bootstrap 4 -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<link href="https://fonts.googleapis.com/css?family=Swanky+and+Moo+Moo" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=PT+Mono" rel="stylesheet">

<script>
    $(document).ready(function(){
        // Tabela de todas de vacinas
        $('#vaccineTable').DataTable({
            "language": {
                "decimal":        "",
                "emptyTable":     "Não há informações na tabela",
                "info":           "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty":      "Mostrando 0 a 0 de 0 entradas",
                "infoFiltered":   "(Filtrados de um total de _MAX_ entradas)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrar _MENU_ entradas",
                "loadingRecords": "Carregando...",
                "processing":     "Processando...",
                "search":         "Procurar:",
                "zeroRecords":    "Não foram econtrados registros correspondentes",
                "paginate": {
                    "first":      "Primeira",
                    "last":       "Última",
                    "next":       "Próxima",
                    "previous":   "Anterior"
                },
                "aria": {
                    "sortAscending":  ": ativar ordenação crescente da coluna",
                    "sortDescending": ": ativar ordenação decrescente da coluna"
                }
            }
        });
        
        // Select de nome de vacinas na adição de doses
        // Nome das vacinas, sem formatação, vindos da DoseController
        var vaccinesName = {!! json_encode($vaccinesName->toArray()) !!};

        // Array com os nomes dos pacientes formatados
        // para o select
        var vaccinesNameSelect = [];

        // Formatação para adequação ao select
        for (key in vaccinesName) {
            vaccinesNameSelect.push({id:vaccinesName[key].id, text:vaccinesName[key].name});
        };

        // Select de pacientes na adição de doses
        // Nome dos pacientes, sem formatação, vindos da DoseController
        var patientsName = {!! json_encode($patientsName->toArray()) !!};

        // Array com os nomes dos pacientes formatados
        // para o select
        var patientsSelect = [];

        // Formatação para adequação ao select
        for (key in patientsName) {
            patientsSelect.push({id:patientsName[key].name, text:patientsName[key].name});
        };
        
        // Inicialização select de nome da vacina no formulário de registro de dose
        $('#vaccineNameSelect').select2({
            "data": vaccinesNameSelect,
            "language": {
                "noResults": function(){
                    return "Nenhum resultado foi encontrado...";
                }
            },
        });

        // Inicialização select de paciente no formulário de registro de dose
        $('#patientSelectName').select2({
            "data": patientsSelect,
            "language": {
                "noResults": function(){
                    return "Nenhum resultado foi encontrado...";
                }
            },
        });

        // Evento ao alterar o nome da vacina que 
        // busca o número da próxima dose
        $('.vaccineNameSelect').on("change", function (e) {  
            $.ajax({
                type: "GET",
                data: {
                    // Recupera o id do tipo de vacina e o nome selecionado
                    vaccineId: $('.vaccineNameSelect').val(),
                    patientName: $('.patientSelectName').val()
                },
                url: "{{ route('painel.addDose_ajax')}}",                
                dataType : 'json',
                success: function(response) {
                    $("#numerodose").val(response.doseNumber+"ª");
                },
                error: function(request, status, error) {
                    console.log(error);
                }
            });            
        });

        // Edição da dose
        $('#vaccineTable').on('click','.edit', function (event) {
            // Previne o redirecionamento do link
            event.preventDefault();

            // Id da dose é posto no form de update de dose
            $("#doseIdUpdate").val($(this).parent().find('.doseId').val());
            $.ajax({
                type: "GET",
                data: {
                    // Recupera o id da dose que se quer modificar
                    doseId: $(this).parent().find('.doseId').val()
                },
                url: "{{ route('painel.updateDose_ajax')}}",                
                dataType : 'json',
                success: function(response) {
                    // Valor antigo do local
                    $('#localUpdate').val(response.dose.local);

                    // Valor antigo do nome do paciente
                    $('#patientSelectNameUpdate').val(response.dose.patientName); 
                    $('#patientSelectNameUpdate').trigger('change');

                    // Valor antigo do nome da vacina
                    $('#vaccineNameSelectUpdate').val(response.dose.vaccine_id); 
                    $('#vaccineNameSelectUpdate').trigger('change');                

                    // Valor antigo de validade
                    $("#dateUpdate").val(response.dose.validade);                    
                    $("#doseUpdateModal").modal("show");                    
                },
                error: function(request, status, error) {
                    alert("Algum erro ocorreu na requisição, tente mais tarde.");
                }
            });

            // Inicialização select de nome da vacina no formulário de atualização de dose
            $('#vaccineNameSelectUpdate').select2({
                "data": vaccinesNameSelect,
                "language": {
                    "noResults": function(){
                        return "Nenhum resultado foi encontrado...";
                    }
                },
            });

            // Inicialização select de paciente no formulário de atualização de dose
            $('#patientSelectNameUpdate').select2({
                "data": patientsSelect,
                "language": {
                    "noResults": function(){
                        return "Nenhum resultado foi encontrado...";
                    }
                },
            });
        });

        // Evento ao alterar o nome da vacina que 
        // busca os números de doses possíveis no
        // formulário de alteração de dose
        $('.selectsUpdate').on("change", function (e) {  
            $.ajax({
                type: "GET",
                data: {
                    // Recupera o id da dose escolhida para o update
                    doseId: $('#doseIdUpdate').val(),
                    
                    // Recupera o id do tipo de vacina e o nome selecionado
                    vaccineId: $('#vaccineNameSelectUpdate').val(),
                    patientName: $('#patientSelectNameUpdate').val()
                },
                url: "{{ route('painel.updateDoseNumber_ajax')}}",                
                dataType : 'json',
                success: function(response) {
                    // Remove as opções anteriores
                    $("#doseSelectUpdate").empty().trigger("change");

                    // Array com os números das doses formatados
                    // para o select
                    var doseNumberSelect = [];

                    // Formatação para adequação ao select de número de doses
                    // Doses podem possuir valores de 1 a 15(É a minha definição,
                    // alterar no DoseController se mais números forem necessários)
                    for (key in response.doseNumbersPossibilities) {
                        doseNumberSelect.push({id:response.doseNumbersPossibilities[key], text:response.doseNumbersPossibilities[key]+"ª"});
                    };

                    // Inicialização select de números de doses no formulário de atualização de dose
                    $('#doseSelectUpdate').select2({
                        "data": doseNumberSelect,
                        "language": {
                            "noResults": function(){
                                return "Nenhum resultado foi encontrado...";
                            }
                        },
                    });

                    // Adiciona os novos números de doses provenientes da requisição ajax
                    $('#mySelect2').trigger({
                        type: 'select2:select',
                        params: {
                            data: doseNumberSelect
                        }
                    });

                    // Deixa selecionado o primeiro valor possível do número da dose
                    $('#doseSelectUpdate').val(doseNumberSelect[0].id); 
                    $('#doseSelectUpdate').trigger('change');                    
                },
                error: function(request, status, error) {
                    console.log(error);
                }
            });            
        });
    });
</script>
@endsection


	

    