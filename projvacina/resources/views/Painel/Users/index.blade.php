@extends('painel.templates.template')

@section('content')
<div class="actions">
    <div class="container">
   

       
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
<br>
  <input class="form-control" id="myInput" type="text" placeholder="Aqui é possivel pesquisar usuarios de acordo com os caracteres">
  
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
        <tbody id="myTable">
        <tr>
        <td>{{$user->id}}</td>
        <td>{{$user->name}}</td>
        
            <td>{{$user->email}}</td>
           
            <td></td>
            
            <td id="center">
                             <a href="{{route('users.edit', $user->id)}}" 
                                               data-toggle="tooltip" 
                                               data-placement="top"
                                               title="Alterar"><i class="fa fa-pencil-square-o"></i></a>
                                               
                                            &nbsp;<form style="display: inline-block;" method="POST" 
                                                        action="{{route('users.destroy', $user->id)}}"                                                        
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Excluir" 
                                                        onsubmit="return confirm('Confirma exclusão?')">
                                                {{method_field('DELETE')}}{{ csrf_field() }}                                                
                                                <button type="submit" style="background-color: #fff">
                                                    <a><i class="fa fa-trash"></i></a>                                                    
                                                </button></form></td> 
        </tr>
        </tbody>
        @empty
        <tr>
            <td colspan="90">
                <p>Nenhum Resultado!</p>
            </td>
        </tr>
        @endforelse
    </table>

</div>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@endsection