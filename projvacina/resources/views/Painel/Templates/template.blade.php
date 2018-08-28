<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Painel </title>
    <!-- FALTA CORRIGIR AS IMAGENS -->

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!--Fonts-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<!--CSS-->
	<link rel="stylesheet" href="{{url("Assets\Painel\css\acl-painel.css")}}">

	<!--Favicon-->
	<link rel="icon" type="image/png" href="{{url("Assets\Painel\imgs\favicon-acl.png")}}">
</head>
<body>
	<div class="menu">
		<ul class="menu col-md-12">
			<li class="col-md-2 text-center">
				<a href="/painel">
                <img src="{{url("Assets\Painel\imgs/acl-branca.png")}}" alt="acl" class="logo-login">				</a>
			</li>
			@can('view_users')
			<li class="col-md-2 text-center">
				<a href="/painel/users">
					<img src="{{url("Assets\Painel\imgs\perfil-acl.png")}}" alt="Meu Perfil" class="img-menu">
					<h1>Usuários</h1>
				</a>
			</li>
			@endcan

			@can('view_vacina')
			<li class="col-md-2 text-center">
				<a href="/painel/vacinas">
				<img src="{{url("assets/painel/imgs/noticias-acl.png")}}" alt="Posts" class="img-menu">
					<h1>Vacinas</h1>
				</a>
			</li>
			@endcan

			@can('view_roles')
			<li class="col-md-2 text-center">
				<a href="/painel/roles">
				<img src="{{url("assets/painel/imgs/funcao-acl.png")}}" alt="Roles" class="img-menu">
					<h1>Funções</h1>
				</a>
			</li>
			@endcan

			@can('view_permissions')
			<li class="col-md-2 text-center">
				<a href="/painel/permissions">
					<img src="{{url("Assets\Painel\imgs\permissao-acl.png")}}" alt="Musicas" class="img-menu">
					<h1>Permissões</h1>
				</a>
			</li>
			@endcan

			<li class="col-md-2 text-center">
				<a href="/logout">
					<img src="{{url("Assets\Painel\imgs\sair-acl.png")}}" alt="Sair" class="img-menu">
					<h1>Sair</h1>
				</a>
			</li>
			<li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
		</ul>
	</div><!--Menu-->

	

	@yield("content")

	<div class="clear"></div>

	<div class="footer actions">
		<div class="container text-center">
			<p class="footer">ProjetoVacina - Todos os direitos reservados</p>
		</div>
	</div>


	<!--jQuery-->
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>