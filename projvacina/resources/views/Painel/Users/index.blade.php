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
        @can('view_users') 
       
       <div class="col-md-2 text-center">
               <a href="/painel/newfunction">
               
               <span style="font-size: 50px; color: #fff;">
 <i class="fas fa-user-shield"><h1 class="subtitle">Alterar Função</h1></i>
 
</span>
                   
               </a>
</div>

@endcan
    </div>
</div><!--Actions-->

<div class="clear"></div>

<div class="container">
    <h1 class="title">
        Listagem das users
    </h1>

    <table class="table table-hover">
        <tr>
        <th>Id</th>
        <th>Nome</th>
            <th>E-mail</th>
            <th>Função</th>
            
            <th width="100px">Ações</th>
        </tr>

        @forelse( $users as $user )
        <tr>
        <td>{{$user->id}}</td>
        <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
           
            <td></td>
            
            <td>
                <a href="{{url("/painel/user/$user->id/edit")}}" class="edit">
                    <i class="fa fa-pencil-square-o"></i>
                </a>
                <a href="{{url("/painel/user/$user->id/delete")}}" class="delete">
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