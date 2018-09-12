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
            
            <td id="center">
                             <a href="{{route('users.edit', $user->id)}}" 
                                               data-toggle="tooltip" 
                                               data-placement="top"
                                               title="Alterar"><i class="fa fa-pencil"></i></a>
                                            &nbsp;<form style="display: inline-block;" method="POST" 
                                                        action="{{route('users.destroy', $user->id)}}"                                                        
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Excluir" 
                                                        onsubmit="return confirm('Confirma exclusão?')">
                                                {{method_field('DELETE')}}{{ csrf_field() }}                                                
                                                <button type="submit" style="background-color: #fff">
                                                    <a><i class="fa fa-trash-o"></i></a>                                                    
                                                </button></form></td> 
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