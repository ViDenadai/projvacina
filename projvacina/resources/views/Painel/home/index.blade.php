@extends('painel.Templates.template')
{{-- extende o template do painel --}}
@section('content')

<div class="relatorios">
    <div class="container">
        <ul class="relatorios">
        @can('view_vacina')
            <li class="col-md-6 text-center">
                <a href="/painel/vacinas">
                    {{-- essa rota lista todas as vacinas do usuario logado no sistema --}}
                    <img src="{{url("assets/painel/imgs/noticias-acl.png")}}" alt="Posts" class="img-menu">
                    @can('create_vacina') <h1 class="subtitle" >{{$totalPosts}}</h1>@endcan
                    {{-- numero total de registros de doses no sistema --}}
                    @can('view_vacina') <h1 class="subtitle" >Visualizar as minhas vacinas</h1>@endcan
                </a>
            </li>
            @endcan
            @can('view_roles')
            <li class="col-md-6 text-center">
                <a href="/painel/roles">
                    {{-- essa rota lista todas as funções de usuario no sistema --}}
                    <img src="{{url("assets/painel/imgs/funcao-acl.png")}}" alt="Roles" class="img-menu">
                    <h1>{{$totalRoles}}</h1>
                    {{-- numero total de registros de funções no sistema --}}
                    <h1 class="subtitle" >Visualizar as funções</h1>
                </a>
            </li>
            @endcan
           
            <div class="clear"></div>
            @can('view_permissions')
            <li class="col-md-6 text-center">
                <a href="/painel/permissions">
                    {{-- essa rota lista todas as perissões no sistema  --}}
                    <img src="{{url("assets/painel/imgs/permissao-acl.png")}}" alt="Permissions" class="img-menu">
                    <h1>{{$totalPermissions}}</h1>
                    {{-- numero total de registros de permissões no sistema --}}
                    <h1 class="subtitle" >Visualizar as permissões</h1>
                </a>
            </li>
            @endcan
            @can('view_users')
            <li class="col-md-6 text-center">
                <a href="/painel/users">
                    {{-- essa rota lista todos os usuarios no sistema --}}
                    <img src="{{url("assets/painel/imgs/perfil-acl.png")}}" alt="Usuários" class="img-menu">
                    <h1>{{$totalUsers}}</h1>
                    {{-- numero total de registros de usuarios no sistema --}}
                    <h1 class="subtitle" >Visualizar todos usuários</h1>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</div><!--Relatorios-->
@endsection