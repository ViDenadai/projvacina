@extends('painel.templates.template')

@section('content')
<html lang="pt">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>
<body>
<!--Filters and actions-->
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
</body>
</html>
@endsection