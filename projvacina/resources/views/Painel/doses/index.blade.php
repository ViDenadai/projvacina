@extends('painel.templates.template')

@section('content')
<div class="container">
    @if(!empty($successMsg))
    <div class="alert alert-success" role="alert"><i class="fas fa-check"></i> {{ $successMsg }} </div>
    @endif
    <br>
    <h1 class="title-card">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <b>Minhas Vacinas</b>
            </div>
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

    <!-- Modal de adição de doses -->
    <div class="modal fade" id="doseAddModal" role="dialog" aria-labelledby="doseAddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('painel.storeDose') }}" aria-label="{{ __('formDoseAdd') }}">
                    <!-- Modal header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Adicionar Dose</b></h5>
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
                                <select id="patientSelectName" 
                                    class="selectsAdd" 
                                    name="patientSelectName" 
                                    style="width: 100%" 
                                    required></select>
                            </div>
                        </div>

                        <!-- Nome da vacina -->
                        <div class="form-group row">
                            <label for="nome" class="col-md-4 col-form-label text-md-right">{{ __('Nome da vacina') }}</label>
                            <div class="col-md-6">
                                <select id="vaccineNameSelect" 
                                    class="selectsAdd" 
                                    name="vaccineNameSelect" 
                                    style="width: 100%" 
                                    required></select>
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

<!-- Fonts -->
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
        
        // Inicialização select de paciente no formulário de registro de dose
        $('#patientSelectName').select2({
            "data": patientsSelect,
            "language": {
                "noResults": function(){
                    return "Nenhum resultado foi encontrado...";
                }
            },
        });

        // Inicialização select de nome da vacina no formulário de registro de dose
        $('#vaccineNameSelect').select2({
            "data": vaccinesNameSelect,
            "language": {
                "noResults": function(){
                    return "Nenhum resultado foi encontrado...";
                }
            },
        });        

        // Evento ao alterar o nome da vacina que 
        // o paciente -> busca o número da próxima dose 
        // no formulário de adição de dose
        $('.selectsAdd').on("change", function (e) {
            $.ajax({
                type: "GET",
                data: {
                    // Recupera o id do tipo de vacina e o nome selecionado
                    vaccineId: $('#vaccineNameSelect').val(),
                    patientName: $('#patientSelectName').val()
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
    });
</script>
@endsection


	

    