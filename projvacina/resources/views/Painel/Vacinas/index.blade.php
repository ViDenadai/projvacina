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
                    <a href="/painel/newDose" data-toggle="modal" data-target="#vaccineAddModal">
                        <b><i class="far fa-plus-square add"></i></b>
                    </a>  
                </div>
            @endif
        </div>
    </h1>
    <hr>
    <table id="myVaccineTable" class="myVaccineTable table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="firstHeader">
                    <!-- <span class="sup">Vacinas</span>
                    <span class="inf">Doses</span> -->
                </th>
                @foreach($vaccinesName as $vaccineName)
                    <th>{{ $vaccineName->name }}</th>                    
                @endforeach
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>1ª Dose</td>
                    @foreach($myDoses as $dose)                        
                        <td>
                        Nome: {{ $dose->vaccine_name }}
                        Nº: {{ $dose->numerodose }}
                        Validade: {{ $dose->validade }}
                        Local: {{ $dose->local }} 
                        </td>
                    @endforeach                       
                </tr>
        </tbody>
    </table>

    <!-- Se o usuário for administrador ele pode ver todas as vacinas (1 - adm; 2 - usuário comum; 3 - profissional da saúde) -->
    @if ($userType == 1)
        <h1 class="title">
            <div class="d-flex">
                <div class="mr-auto p-2"><b>Todas as Vacinas</b></div>
                @if (Auth::user()->can('create_dose'))
                    <div class="ml-auto p-2">
                        <a href="/painel/newDose" data-toggle="modal" data-target="#vaccineAddModal">
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
                            <a href="{{url('/painel/dose/$dose->id/edit')}}" class="edit" title="Editar">
                                <i class="fa fa-pencil-square-o"></i>
                            </a>
                        @endif
                        @if(Auth::user()->can('delete_dose'))
                            <form style="display: inline-block;" method="POST" 
                                action="{{route('painel.deleteDose')}}"                                                        
                                data-toggle="tooltip" data-placement="top"
                                title="Excluir" 
                                onsubmit="return confirm('Confirmar exclusão?')">
                                <input type="hidden" id="doseId" name="doseId" value='{{ $dose->id }}'>
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
    <div class="modal fade" id="vaccineAddModal" role="dialog" aria-labelledby="vaccineAddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('painel.storeDose') }}" aria-label="{{ __('formVaccine') }}">
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
                                    type="local" 
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
                                <input id="numerodose" type="text" class="form-control" name="numerodose" style="width: 11%" value="" required disabled>
                                <!-- <select class="doseSelect" id="numerodose" name="numerodose" style="width: 15%" required disabled>
                                    <option value="1">1ª</option>
                                    <option value="2">2ª</option>
                                    <option value="3">3ª</option>
                                    <option value="4">4ª</option>
                                    <option value="5">5ª</option>
                                </select> -->
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
        
        // Inicialização select de nome da vacina 
        $('#vaccineNameSelect').select2({
            "data": vaccinesNameSelect,
            "language": {
                "noResults": function(){
                    return "Nenhum resultado foi encontrado...";
                }
            },
        })

        // Inicialização select de paciente   
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
                    // Recupera o id do tipo de vacina selecionado
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

        // Inicialização select de número da dose 
        // $('#numerodose').select2({
        //     "language": {
        //         "noResults": function(){
        //             return "";
        //         }
        //     },
        // });
    });
</script>
@endsection


	

    