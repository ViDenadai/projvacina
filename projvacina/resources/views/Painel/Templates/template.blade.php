<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Minhas Vacinas </title>
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> -->

	<!-- Latest compiled and minified CSS -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> -->
	
	<!-- Optional theme -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous"> -->

	<!--Fonts-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	
	<!--CSS-->
	<link rel="stylesheet" href="{{url("Assets\Painel\css\acl-painel.css")}}">

	<!--Favicon-->
	<link rel="icon" type="image/png" href="{{url("Assets\Painel\imgs\favicon-acl.png")}}">
	
	<!--icones utilizados no sistemas estão disponiveis em https://fontawesome.com/   -->
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">	

	<style>
		html, body {
			/* imagem de fundo do painel */
			/* background-image : url("fundos.jpg");  */
			background-color: white;
			font-family: 'Nunito', sans-serif;
			font-weight: 200;
			height: 100vh;
			margin: 0;
		}
	</style>

	@yield("styles")

</head>
<body>
	<div class="wrapper">
		<!-- Sidebar -->
		<nav id="sidebar">		
			<div class="sidebar-header">
				<a class="navbar-brand pb-4" href="/painel">
					<img src="{{url('Assets\Painel\imgs\acl-branca.png')}}" alt="acl" class="logo-login">
				</a>
				<div class="dropdown-divider pb-1"></div>			
				<p class="d-flex justify-content-left">Bem Vindo!</p>
				<p class="d-flex justify-content-left pb-0">{{ Auth::user()->name }}</p>
				<div class="dropdown-divider pb-1"></div>	
			</div>
			
			<ul class="list-unstyled components">
				@if(Gate::check('view_users') || Gate::check('view_roles') || Gate::check('view_permissions'))
				<li>
					<!-- Seção de funcionalidades relacionadas ao usuário -->
					<a href="#usersSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user"></i> Usuários</a>
					<ul class="collapse list-unstyled" id="usersSubmenu">
						@can('view_users')
						<li>
							<a href="/painel/users">
								<i class="fa fa-list" aria-hidden="true"></i> Listar usuários
								<!-- <img src="{{url('Assets\Painel\imgs\perfil-acl.png')}}" alt="Meu Perfil" class="img-menu"> -->						
							</a>
						</li>
						@endcan

						@can('view_roles')
						<li>
							<a href="/painel/roles">
								<i class="fas fa-user-cog"></i> Tipos de usuário
								<!-- <img src="{{url('Assets\Painel\imgs\funcao-acl.png')}}" alt="roles" class="img-menu"> -->						
							</a>
						</li>
						@endcan

						@can('view_permissions')
						<li>
							<a href="/painel/permissions">
								<i class="fas fa-user-lock"></i> Permissões de usuário
								<!-- <img src="{{url('Assets\Painel\imgs\permissao-acl.png')}}" alt="permissions" class="img-menu"> -->								
							</a>
						</li>
						@endcan
					</ul>					
				</li>
				@endif

				<!-- Seção de vacinas -->
				@can('view_vacina')
				<li>
					<a href="/painel/vacinas">
						<i class="fas fa-syringe"></i> Vacinas
						<!-- <img src="{{url('Assets\painel\imgs\noticias-acl.png')}}" alt="Posts" class="img-menu"> -->						
					</a>
				</li>
				@endcan

				<!-- Seção para desconectar do sistema -->
				<li>
					<a href="{{ route('logout') }}"
						onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
						<i class="fas fa-sign-out-alt"></i> Desconectar
						<!-- <img src="{{url('assets/painel/imgs/sair-acl.png')}}" alt="Sair" class="img-menu"> -->						
					</a>
										
					<form id="logout-form" 
						action="{{ route('logout') }}" 
						method="POST" 
						style="display: none;">
						@csrf
					</form>
				</li>
			</ul>
		</nav>

		<!-- Conteúdo da página -->
		<div id="content">
			<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
				<div class="container-fluid">
					<button type="button" id="sidebarCollapse" class="btn btn-info">
						<i class="fas fa-align-left"></i>
						<span>Toggle Sidebar</span>
					</button>
				</div>
			</nav> -->
			@yield("content")			
		</div>
	</div>
	
	{{-- @yield("content") --}}

	<!-- <div class="clear"></div> -->

	<!-- <div class="footer actions">
		<div class="container text-center">
			<p class="footer">ProjetoVacina - Todos os direitos reservados</p>
		</div>
	</div> -->
	
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	@yield("scripts")
</body>
</html>