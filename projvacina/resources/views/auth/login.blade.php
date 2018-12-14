@extends('auth.templates.unlogged')

@section('content-form')
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<a class="navbar-brand pb-2" href="/">
                    <img src="{{url("Assets\Painel\imgs/acl-branca.png")}}" alt="acl" class="logo-login2">
                </a>                
			</div>
			<div class="card-body">
                {{-- Form login, composto por email e senha --}}
                <form class="login form" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                    @csrf

                    {{-- E-mail --}}
                    <div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input id="email" 
                            type="email" 
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="E-mail"
                            required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert" >
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
					</div>

                    {{-- Senha --}}
                    <div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
                        <input id="password" 
                            type="password" 
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" 
                            name="password"
                            placeholder="Senha" 
                            required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
					</div>

                    {{-- Lembrar-me --}}
                    <div class="row align-items-center remember">
                        <input type="checkbox" 
                            name="remember" 
                            id="remember" 
                            {{ old('remember') ? 'checked' : '' }}><b style="color: black;">{{ __('Lembrar-me') }}</b>
					</div>
                
                    {{-- Login --}}
                    <div class="form-group pt-4">
						<input type="submit" value="{{ __('Login') }}" class="btn float-right login_btn">
					</div>
                </form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					Não é cadastrado ainda?<a class="login-link" href="{{ route('register') }}">Cadastre-se</a>
				</div>
				<div class="d-flex justify-content-center">
                    <a class="login-link" href="{{ route('password.request') }}">
                        {{ __('Esqueceu sua senha?') }}
                    </a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- <a href="/"><i class="fas fa-home"></i></a>
<div class="login-header">
    <img src="{{url("Assets\Painel\imgs/acl-branca.png")}}" alt="acl" class="logo-login2">
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">            
                <div class="card-body">
                    <form class="login form" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="form-group">
                            {{-- formulario de login composto por email e senha --}}
                            <div class="col-md-7">
                            E-mail:
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert" >
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            

                            <div class="col-md-7">
                            Senha:
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-7 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Lembrar-me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-7 offset-md-4">
                                <button type="submit" class="btn btn-login">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Esqueceu sua senha?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
