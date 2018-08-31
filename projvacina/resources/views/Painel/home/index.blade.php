@extends('painel.Templates.template')

@section('content')

<div class="relatorios">
    <div class="container">
        <ul class="relatorios">
        @can('view_vacina')
            <li class="col-md-6 text-center">
                <a href="/painel/vacinas">
                    <img src="{{url("assets/painel/imgs/noticias-acl.png")}}" alt="Posts" class="img-menu">
                    @can('create_vacina') <h1 class="subtitle" >{{$totalPosts}}</h1>@endcan
                    @can('view_vacina') <h1 class="subtitle" >Visualizar as minhas vacinas</h1>@endcan
                </a>
            </li>
            @endcan
            @can('view_roles')
            <li class="col-md-6 text-center">
                <a href="/painel/roles">
                    <img src="{{url("assets/painel/imgs/funcao-acl.png")}}" alt="Roles" class="img-menu">
                    <h1>{{$totalRoles}}</h1>
                    <h1 class="subtitle" >Visualizar as funções</h1>
                </a>
            </li>
            @endcan
           
            <div class="clear"></div>
            @can('view_permissions')
            <li class="col-md-6 text-center">
                <a href="/painel/permissions">
                    <img src="{{url("assets/painel/imgs/permissao-acl.png")}}" alt="Permissions" class="img-menu">
                    <h1>{{$totalPermissions}}</h1>
                    <h1 class="subtitle" >Visualizar as permissões</h1>
                </a>
            </li>
            @endcan
            @can('view_users')
            <li class="col-md-6 text-center">
                <a href="/painel/users">
                    <img src="{{url("assets/painel/imgs/perfil-acl.png")}}" alt="Usuários" class="img-menu">
                    <h1>{{$totalUsers}}</h1>
                    <h1 class="subtitle" >Visualizar todos usuários</h1>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</div><!--Relatorios-->
@endsection