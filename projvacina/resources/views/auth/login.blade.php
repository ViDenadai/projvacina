@extends('auth.templates.unlogged')

@section('content-form')
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
                <div class="d-flex justify-content-start">
                    <div class="pt-1 login-first-head">
                        <a class="navbar-brand pb-2" href="/">  
                            <i class="fas fa-home"></i>
                        </a>                         
                    </div>
                    
                    <div class="pt-1">
                        <a class="pb-2" href="/">                     
                            <img src="{{url("Assets\Painel\imgs/acl-branca.png")}}" alt="acl" class="logo-login2">
                        </a>                     
                    </div>
                </div>                                                                                                                     
			</div>
			<div class="card-body">
                {{-- Form login, composto por email e senha --}}
                <form id="formLogin" 
                    class="login form" 
                    method="POST" 
                    action="{{ route('login') }}" 
                    aria-label="{{ __('Login') }}">
                    @csrf

                    {{-- E-mail --}}
                    <div class="input-group form-group pt-3">
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
                    <div class="form-group pt-2">
						<input type="submit" value="{{ __('Login') }}" class="btn float-right login_btn">
					</div>
                </form>
			</div>
			<div class="card-footer pt-4">
				<div class="d-flex justify-content-center links">
					Não é cadastrado ainda?<a id="registerLink" class="login-link" href="#">Cadastre-se</a>
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

<!-- Modal de adição do usuário -->
<div class="modal fade" id="userAddModal" role="dialog" aria-labelledby="userAddModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form class="" 
                method="POST" 
                action="{{ route('userRegister') }}" 
                aria-label="{{ __('formAddUser') }}" 
                id="formAddUser"
                oninput='passwordAdd_confirm.setCustomValidity(passwordAdd_confirm.value != passwordAdd.value ? "As senhas não são iguais." : "")'>               
                
                <!-- Modal header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel"><b>Registrar usuário</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <!-- CSRF protection -->
                    @csrf

                    <!-- Nome -->
                    <div class="form-group row">
                        <label for="nameAdd" class="col-md-4 col-form-label text-md-right">{{ __('Nome Completo') }}</label>
                        <div class="col-md-6">                    
                            <input id="nameAdd" 
                                type="text" 
                                class="nameAdd form-control" 
                                name="nameAdd" value="{{ old('nameAdd') }}" 
                                required autofocus>
                        </div>
                    </div>

                    <!-- E-mail -->
                    <div class="form-group row">
                        <label for="emailAdd" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail ') }}</label>
                        <div class="col-md-6">
                            <input id="emailAdd" 
                                type="email" 
                                class="emailAdd form-control" 
                                name="emailAdd" 
                                value="{{ old('emailAdd') }}" 
                                required>
                        </div>
                    </div>

                    <!-- Senha -->
                    <div class="form-group row">
                        <label for="passwordAdd" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>
                        <div class="col-md-6">
                            <input id="passwordAdd" 
                                type="password"
                                class="passwordAdd form-control" 
                                name="passwordAdd" 
                                required>
                        </div>
                    </div>

                    <!-- Confirmar senha -->
                    <div class="form-group row">
                        <label for="passwordAdd_confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirme a senha') }}</label>
                        <div class="col-md-6">
                            <input id="passwordAdd_confirm" 
                                type="password" 
                                class="passwordAdd_confirm form-control" 
                                name="passwordAdd_confirm" 
                                required>
                        </div>
                    </div>

                    <!-- Data de nascimento -->
                    <div class="form-group row">
                        <label for="birthDate" class="col-md-4 col-form-label text-md-right">{{ __('Data de nascimento') }}</label>
                        <div class="col-md-6">
                            <input id="birthDate" 
                                type="date" class="birthDate form-control" 
                                name="birthDate" 
                                required>
                        </div>
                    </div>            
                </div>                                
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" >{{ __('Registrar') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<!-- SweetAlert2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.32.4/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function(){ 
        // Hash vinda da landing page, utilizada
        // para abrir o modal de cadastro
        var hash = window.location.hash;
        if (hash == "#openRegModal"){
            setTimeout(function(){
                $('#userAddModal').modal({backdrop: 'static', show: true});
            }, 500);  
        }

        // Registro do usuário
        $('#registerLink').on('click', function (event) {
            // Previne o redirecionamento do link            
            event.preventDefault();

            // Exibe o modal de registro e previne fechamento ao clicar fora de sua área
            setTimeout(function(){
                $('#userAddModal').modal({backdrop: 'static', show: true});    
            }, 350);   
        });

        // Envio das informações de cadastro
        $('#formAddUser').submit(function(event) {
            // Previne o submit do form            
            event.preventDefault();
            $.ajax({
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    nameAdd: $(this).parent().find('#nameAdd').val(),
                    emailAdd: $(this).parent().find('#emailAdd').val(),
                    passwordAdd: $(this).parent().find('#passwordAdd').val(),
                    birthDate: $(this).parent().find('#birthDate').val()
                },
                url: "{{ route('userRegister')}}",                
                dataType : 'json',
                success: function(response) {
                    Swal({
                        allowOutsideClick: false,
                        target: document.getElementById('#userAddModal'),
                        type: 'success',
                        title: 'Usuário cadastrado!',
                        showCancelButton: true,
                        cancelButtonColor: '#ff1c1c',
                        cancelButtonText: 'Fechar',
                        confirmButtonColor: '#28a745',
                        confirmButtonText: 'Acessar a plataforma',
                        reverseButtons: true,
                    }).then(function(isConfirm) {
                        console.log(isConfirm.value);
                        if (isConfirm.value){
                            // Login do usuário
                            $("#email").val($('#emailAdd').val());
                            $("#password").val($('#passwordAdd').val());
                            $("#formLogin").submit();                                                         
                        }

                        // Reseta os valores do form de registro e fecha o modal
                        $('#formAddUser')[0].reset();
                        $('#userAddModal').modal('hide');  
                                              
                    });
                },
                error: function(request, status, error) {
                    Swal({
                        allowOutsideClick: false,
                        target: document.getElementById('#userAddModal'),
                        type: 'error',
                        title: 'Erro',
                        text: 'Algo não ocorreu bem, tente mais tarde.'
                    });
                }
            });
        });
    });
</script>
@endsection
