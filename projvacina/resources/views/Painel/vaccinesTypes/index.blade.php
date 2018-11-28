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
                        </a>
                        <form style="display: inline-block;" method="POST" 
                            action="{{route('painel.deleteVaccine')}}"                                                        
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
                <form method="POST" action="{{ route('painel.storeVaccine') }}" aria-label="{{ __('formVaccine') }}">
                    <!-- Modal header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar tipo de vacina</h5>
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
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome da vacina') }}</label>
                            <div class="col-md-6">
                                <input id="name" 
                                    type="text" 
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                    name="name" value="{{ old('name') }}" 
                                    required 
                                    autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
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
</div>
@endsection

@section("scripts")
<!-- DataTable -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>

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
        $('.edit').on('click', function () {
            var vaccineId = $(this).closest('.vaccineId').val();
            console.log(vaccineId);
            // var Status = $(this).val();
            // $.ajax({
            //     url: 'Ajax/StatusUpdate.php',
            //     data: {
            //         text: $("textarea[name=Status]").val(),
            //         Status: Status
            //     },
            //     dataType : 'json'
            // });
        });

    });
</script>
@endsection
