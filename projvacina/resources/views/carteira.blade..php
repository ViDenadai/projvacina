@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Minhas Carteira de vacinas</div>


                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Você esta logado! 
                    @forelse($doses as $dose)
<p>Nome:
    {{$dose->nome}}
</p>
<p>Local:
    {{$dose->local}}
</p>
<p>Validade:
    {{$dose->validade}}
</p>
<p>Dosagem:
    {{$dose->numerodose}}
</p>
</br>
@empty
<p>
    sem doses cadastradas!!
</p>
@endforelse
@endsection

                </div>
            </div>
        </div>
    </div>
</div>

