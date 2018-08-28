@extends('painel.templates.template')

@section('content')

<!--Filters and actions-->
<div class="actions">
    <div class="container">
        <a class="add" href="forms">
            <i class="fa fa-plus-circle"></i>
        </a>

        <form class="form-search form form-inline">
            <input type="text" name="pesquisar" placeholder="Pesquisar?" class="form-control">
            <input type="submit" name="pesquisar" value="Encontrar" class="btn btn-success">
        </form>

        <div class="col-md-2 text-center">
				<a href="/caddose">
				<img src="{{url("assets/painel/imgs/vacinaplus.png")}}" alt="Posts" class="img-submenu">
					<h1 class="subtitle">Adicionar Dose</h1>
				</a>
</div>
    </div>
</div><!--Actions-->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrar Dose') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('caddose.store') }}" aria-label="{{ __('Register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="nome" class="col-md-4 col-form-label text-md-right">{{ __('Nome da vacina') }}</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" name="nome" value="{{ old('nome') }}" required autofocus>

                                @if ($errors->has('nome'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nome') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="local" class="col-md-4 col-form-label text-md-right">{{ __('Local de aplicação ') }}</label>

                            <div class="col-md-6">
                                <input id="local" type="local" class="form-control{{ $errors->has('local') ? ' is-invalid' : '' }}" name="local" value="{{ old('local') }}" required>

                                @if ($errors->has('local'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('local') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_user" class="col-md-4 col-form-label text-md-right">{{ __('ID do Paciente') }}</label>

                            <div class="col-md-6">
                                <input id="id_user" type="id_user" class="form-control{{ $errors->has('id_user') ? ' is-invalid' : '' }}" name="id_user" required>

                                @if ($errors->has('id_user'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('id_user') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="numerodose" class="col-md-4 col-form-label text-md-right">{{ __('Numero da dose') }}</label>

                            <div class="col-md-6">
                                <input id="numerodose" type="number"  min="1" max="5" class="form-control" name="numerodose" required>
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="validade" class="col-md-4 col-form-label text-md-right">{{ __('Validade') }}</label>

                            <div class="col-md-6">
                                <input id="date" type="date" class="form-control{{ $errors->has('validade') ? ' is-invalid' : '' }}" name="validade" required>

                                @if ($errors->has('validade'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('validade') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-login">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
















