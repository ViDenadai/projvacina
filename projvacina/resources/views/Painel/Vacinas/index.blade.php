@extends('painel.templates.template')

@section('content')
<div class="container">
    <br>
    <!-- @can('create_vacina')
        <a href="/painel/newvacina">                
            <span style="font-size: 50px; color: rgba(4, 199, 199, 0.733);">
                <i class="fas fa-syringe"><h1 class="subtitle">Adicionar dose</h1></i>                
            </span>					
        </a>     
    @endcan -->
    <!-- <h2> Filtro </h2>
    <input class="form-control" id="myInput" type="text" placeholder="Digite o nome da"> -->

    <h1 class="title">
        <div class="d-flex">
            <div class="mr-auto p-2"><b>Minhas Vacinas</b></div>
            @can('create_vacina')
                <div class="ml-auto p-2">
                    <a href="/painel/newvacina">
                        <span style="font-size: 35px;">
                            <b><i class="far fa-plus-square"></i></b>
                        </span>	
                    </a>  
                </div>
            @endcan
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
                @can('create_vacina')
                    <th>Nome do usuário</th>
                    <th width="100px">Ações</th>        
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($doses as $dose)
                <tr>
                    <td>{{$dose->nome}}</td>
                    <td>{{$dose->local}}</td>
                    <td>{{$dose->numerodose}}ª</td>
                    <td>{{$dose->validade}}</td>
                    @can('create_vacina')
                        <td>{{$dose->user_name}}</td>
                        <td> 
                            <a href="{{url('/painel/dose/$dose->id/edit')}}" class="edit" title="Editar">
                                <i class="fa fa-pencil-square-o"></i>
                            </a>
                            <form style="display: inline-block;" method="POST" 
                                action="{{route('vacinas.destroy', $dose->id)}}"                                                        
                                data-toggle="tooltip" data-placement="top"
                                title="Excluir" 
                                onsubmit="return confirm('Confirma exclusão?')">
                                {{method_field('DELETE')}}{{ csrf_field() }}                                                
                                <button type="submit" class ="delete">
                                    <i class="fa fa-trash"></i>                                                    
                                </button>
                            </form>
                        </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="pb-3"></p>
</div>
@endsection

@section("scripts")
<!-- DataTable -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>

<script>
    $(document).ready(function(){
        // $("#myInput").on("keyup", function() {
        //     var value = $(this).val().toLowerCase();
        //     $("#myTable tr").filter(function() {
        //     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        //     });
        // });
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
    });
</script>
@endsection


	

    