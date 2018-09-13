@extends('painel.templates.template')

@section('content')
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Carteira com filtros</h2>
  <p>Aqui é possivel pesquisar as doses de acordo com critérios</p>  
  <input class="form-control" id="myInput" type="text" placeholder="Search..">
  <br>
  <table class="table table-bordered">
    <thead>
    <tr>
            <th>Nome</th>
            <th>Local</th>
            <th>Dose</th>
            <th>Validade</th>
            @can('create_vacina')<th>Usuário ID</th>
            
            <th width="100px">Ações</th>
        </tr>@endcan
    </thead>
    <tbody id="myTable">
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