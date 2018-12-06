@extends('painel.templates.template')

@section('content')
<div class="container">
    @if(!empty($successMsg))
    <div class="alert alert-success" role="alert"><i class="fas fa-check"></i> {{ $successMsg }} </div>
    @endif
    <br>
    <h1 class="title">
        <div class="d-flex">
            <div class="mr-auto p-2"><b>Tipos de Vacina</b></div>
                <div class="ml-auto p-2">
                    <a href="/painel/newDose" data-toggle="modal" data-target="#vaccineAddModal">
                        <b><i class="far fa-plus-square add"></i></b>
                    </a>  
                </div>
        </div>
    </h1>
    <hr>
    <table id="vaccineTable" class="table table-striped" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nome das vacinas</th>
                <th width="100px">Ações</th>   
            </tr>
        </thead>
        <tbody>
            @foreach($vaccines as $vaccine)
                <tr>
                    <td>{{$vaccine->name}}</td>
                    <td> 
                        <a class="edit" href="#" title="Editar">
                            <i class="fa fa-pencil-square-o"></i>
                            <input type="hidden" class="vaccineId" id="vaccineId" name="vaccineId" value='{{ $vaccine->id }}'>
                        </a>
                        <form style="display: inline-block;" method="POST" 
                            action="{{ route('painel.deleteVaccine') }}"                                                        
                            data-toggle="tooltip" data-placement="top"
                            title="Excluir" 
                            onsubmit="return confirm('Caso você exclua esse tipo de vacina, todas as doses relacionadas à esse tipo serão excluídas. Você deseja excluir?')">
                            <input type="hidden" class="vaccineId" id="vaccineId" name="vaccineId" value='{{ $vaccine->id }}'>
                            {{-- method_field('DELETE') --}}{{ csrf_field() }}                                                
                            <button type="submit" class ="delete">
                                <i class="fa fa-trash"></i>                                                    
                            </button>
                        </form>
                    </td>      
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal de adição de tipos de vacinas -->
    <div class="modal fade" id="vaccineAddModal" role="dialog" aria-labelledby="vaccineAddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('painel.storeVaccine') }}" aria-label="{{ __('formAddVaccine') }}">
                    <!-- Modal header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel">Adicionar tipo de vacina</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <!-- CSRF protection -->
                        @csrf

                        <!-- Nome da vacina -->
                        <div class="form-group row">
                            <label for="nameAdd" class="col-md-4 col-form-label text-md-right">{{ __('Nome da vacina') }}</label>
                            <div class="col-md-6">
                                <input id="nameAdd" 
                                    type="text"
                                    class="form-control{{ $errors->has('nameAdd') ? ' is-invalid' : '' }}" 
                                    name="nameAdd" value="{{ old('nameAdd') }}" 
                                    required 
                                    autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nameAdd') }}</strong>
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
    <div class="modal fade" id="vaccineUpdateModal" role="dialog" aria-labelledby="vaccineUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('painel.updateVaccine') }}" aria-label="{{ __('formUpdateVaccine') }}">
                    <!-- Modal header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUpdateLabel">Alterar tipo de vacina</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <!-- CSRF protection -->
                        @csrf

                        <!-- Nome da vacina -->
                        <div class="form-group row">
                            <label for="nameUpdate" class="col-md-4 col-form-label text-md-right">{{ __('Nome da vacina') }}</label>
                            <div class="col-md-6">
                                <input id="nameUpdate" 
                                    type="text" 
                                    class="form-control{{ $errors->has('nameUpdate') ? ' is-invalid' : '' }}" 
                                    name="nameUpdate" value="" 
                                    required 
                                    autofocus>
                                    <input type="hidden" id="vaccineIdUpdate" name="vaccineIdUpdate" value="">
                                @if ($errors->has('nameUpdate'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nameUpdate') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
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

<script>
    $(document).ready(function(){
        // Tabela de tipos de vacinas
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
        
        // Edição do tipos de vacina
        $('#vaccineTable').on('click','.edit', function (event) {
            // Previne o redirecionamento do link            
            event.preventDefault();
            $.ajax({
                type: "GET",
                data: {
                    // Recupera o id do tipo de vacina que se quer modificar
                    vaccineId: $(this).parent().find('.vaccineId').val()
                },
                url: "{{ route('painel.updateVaccine_ajax')}}",                
                dataType : 'json',
                success: function(response) {
                    $("#nameUpdate").val(response.vaccine.name);
                    $("#vaccineIdUpdate").val(response.vaccine.id);
                    $("#vaccineUpdateModal").modal("show");
                },
                error: function(request, status, error) {
                    alert("Algum erro ocorreu na requisição, tente mais tarde.");
                }
            });
        });

    });
</script>
@endsection
