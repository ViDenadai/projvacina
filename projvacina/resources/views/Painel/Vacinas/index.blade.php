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
        @can('create_vacina') <!--PRECISA ARRUMAR AQUI-->
       
        <div class="col-md-2 text-center">
				<a href="/caddose">
                
				<span style="font-size: 50px; color: #fff;">
  <i class="fas fa-syringe"><h1 class="subtitle">Adicionar dose</h1></i>
  
</span>
					
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
            @can('create_vacina')<th>Usuário ID</th>
            
            <th width="100px">Ações</th>
        </tr>
        @endcan
        @forelse( $doses as $dose )
       
        <tr>
            <td>{{$dose->nome}}</td>
            <td>{{$dose->local}}</td>
            <td>{{$dose->numerodose}}</td>
            <td>{{$dose->validade}}</td>
            @can('create_vacina')
            <td>{{$dose->id_user}}</td>
            <td> 
                <a href="{{url("/painel/dose/$dose->id/edit")}}" class="edit">
                    <i class="fa fa-pencil-square-o"></i>
                </a>
                @endcan
                 @can('create_vacina')
                <a href="{{url("/painel/dose/$dose->id/delete")}}" class="delete">
                    <i class="fa fa-trash"></i>
                </a>
                @endcan
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