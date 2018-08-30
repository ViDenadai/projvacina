@extends('painel.templates.template')

@section('content')

<!--Filters and actions-->
<div class="actions">
    <div class="container">
        <a class="add" href="forms">
            <i class="fa fa-plus-circle"></i>
        </a>

        <form class="form-search form form-inline">
            <input type="text" name="pesquisar" placeholder="Pesquisar?" class="form-control">
            <input type="submit" name="pesquisar" value="Encontrar" class="btn btn-success">
        </form>
        @can('create_vacina')
        <div class="col-md-2 text-center">
				<a href="/caddose">
				<img src="{{url("assets/painel/imgs/vacinaplus.png")}}" alt="Posts" class="img-submenu">
					<h1 class="subtitle">Adicionar Dose</h1>
				</a>
</div>
@endcan
    </div>
</div><!--Actions-->

<div class="clear"></div>

<div class="container">
    <h1 class="title">
        Listagem das doses
    </h1>

    <table class="table table-hover">
        <tr>
            <th>Nome</th>
            <th>Local</th>
            <th>Dose</th>
            <th>Validade</th>
            <th>Usuário ID</th>
            
            <th width="100px">Ações</th>
        </tr>

        @forelse( $doses as $dose )
       
        <tr>
            <td>{{$dose->nome}}</td>
            <td>{{$dose->local}}</td>
            <td>{{$dose->numerodose}}</td>
            <td>{{$dose->validade}}</td>
            <td>{{$dose->id_user}}</td>
            <td>
                <a href="{{url("/painel/dose/$dose->id/edit")}}" class="edit">
                    <i class="fa fa-pencil-square-o"></i>
                </a>
                <a href="{{url("/painel/dose/$dose->id/delete")}}" class="delete">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
        </tr>
       
        @empty
        <tr>
            <td colspan="90">
                <p>Nenhum Resultado!</p>
            </td>
        </tr>
        
        @endforelse
    </table>

</div>

@endsection