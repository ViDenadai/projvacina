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
         
        @can('create_vacina') 
       
        <div class="col-md-2 text-center">
				<a href="/painel/newvacina">
                
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
<br>
<input class="form-control" id="myInput" type="text" placeholder="Aqui é possivel pesquisar Vacinas de acordo com os caracteres">

    <h1 class="title">
        Listagem das minhas vacinas
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
        <tbody id="myTable">
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
                 &nbsp;<form style="display: inline-block;" method="POST" 
                 action="{{route('vacinas.destroy', $dose->id)}}"                                                        
                 data-toggle="tooltip" data-placement="top"
                 title="Excluir" 
                 onsubmit="return confirm('Confirma exclusão?')">
         {{method_field('DELETE')}}{{ csrf_field() }}                                                
         <button type="submit" style="background-color: #fff">
             <a><i class="fa fa-trash"></i></a>                                                    
         </button></form>
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
        </tbody>
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
	

    