@extends('painel.templates.template')

@section('content')
<div class="container">
    @if(!empty($successMsg))
    <div class="alert alert-success" role="alert"><i class="fas fa-check"></i> {{ $successMsg }} </div>
    @endif
    <br>
    <h1 class="title">
        <div class="d-flex">
            <div class="mr-auto p-2"><b>Todos os usuários</b></div>
            @if (Auth::user()->can('create_users'))
                <div class="ml-auto p-2">
                    <a href="/painel/newDose" data-toggle="modal" data-target="#userAddModal">
                        <b><i class="far fa-plus-square add"></i></b>
                    </a>  
                </div>
            @endif
        </div>
    </h1>
    <hr>
    <table id="userTable" class="table table-striped" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Função</th>
                <th width="100px">Ações</th>   
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <!-- Função -->
                    <td>
                        <!-- As condições abaixo dependem, diretamente, das entradas na tabela
                        roles -->
                        @if( $user->role_name == 'profissional_saude' )
                            Profissional da saúde
                        @elseif ( $user->role_name == 'adm' )
                            Administrador
                        @elseif ( $user->role_name == 'usuario' )
                            Usuário
                        @endif
                    </td>

                    <!-- Ações(Editar/Excluir) -->
                    <td> 
                    @if (Auth::user()->can('edit_users'))
                        <a class="edit" href="#" title="Editar">
                            <i class="fa fa-pencil-square-o"></i>
                            <input type="hidden" class="userId" name="userId" value='{{ $user->id }}'>
                        </a>
                    @endif                        
                        <form style="display: inline-block;" method="POST" 
                            action="{{ route('painel.deleteUser') }}"                                                        
                            data-toggle="tooltip" data-placement="top"
                            title="Excluir" 
                            onsubmit="return confirm('Caso você exclua esse usuário todas as doses relacionadas à ele serão excluídas. Você deseja excluir?')">
                            <!-- A opção de remover só aparece para usuários com essa permissão -->
                            @if (Auth::user()->can('delete_users'))
                                <!-- Não é possível remover o usuário da sessão atual -->
                                @if (Auth::user()->id != $user->id)
                                    <input type="hidden" class="userId" name="userId" value='{{ $user->id }}'>
                                    {{-- method_field('DELETE') --}}{{ csrf_field() }}                                                
                                    <button type="submit" class="delete">
                                        <i class="fa fa-trash"></i>                                                    
                                    </button>
                                @else
                                    <button type="submit" class="delete" disabled>
                                        <i class="fa fa-trash"></i>                                                    
                                    </button>
                                @endif
                            @else
                                <button type="submit" class="delete" disabled>
                                    <i class="fa fa-trash"></i>                                                    
                                </button>
                            @endif
                        </form>                                               
                    </td>      
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal de adição de tipos de vacinas -->
    <div class="modal fade" id="userAddModal" role="dialog" aria-labelledby="userAddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form class="" 
                    method="POST" 
                    action="{{ route('painel.storeUser') }}" 
                    aria-label="{{ __('formAddUser') }}" 
                    id="formAddUser"
                    oninput='passwordAdd_confirm.setCustomValidity(passwordAdd_confirm.value != passwordAdd.value ? "As senhas não são iguais." : "")'>               
                    
                    <!-- Modal header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel">Adicionar usuário</h5>
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
                    
                        <!-- Tipo de usuário -->
                        <div class="form-group row">
                            <label for="roleAddSelect" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de usuário') }}</label>
                            <div class="col-md-6">
                                <select id="roleAddSelect" 
                                    class="roleAddSelect form-control" 
                                    name="roleAddSelect" 
                                    style="width: 100%" 
                                    required></select>                                    
                            </div>
                        </div>
                    </div>                                
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" >{{ __('Adicionar') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de edição do usuário -->
    <div class="modal fade" id="userUpdateModal" role="dialog" aria-labelledby="userUpdateModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('painel.updateUser') }}" aria-label="{{ __('formUpdateUser') }}">
                    <!-- Modal header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUpdateLabel">Alterar informações do usuário</h5>
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
                            <label for="nameUpdate" class="col-md-4 col-form-label text-md-right">{{ __('Nome Completo') }}</label>
                            <div class="col-md-6">                    
                                <input id="nameUpdate" 
                                    type="text" 
                                    class="nameUpdate form-control" 
                                    name="nameUpdate" value="{{ old('nameUpdate') }}" 
                                    required autofocus>
                            </div>
                        </div>

                        <!-- E-mail -->
                        <div class="form-group row">
                            <label for="emailUpdate" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail ') }}</label>
                            <div class="col-md-6">
                                <input id="emailUpdate" 
                                    type="email" 
                                    class="emailUpdate form-control" 
                                    name="emailUpdate" 
                                    value="{{ old('emailUpdate') }}" 
                                    required>
                            </div>
                        </div>

                        <!-- Senha -->
                        <div class="form-group row">
                            <label for="passwordUpdate" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>
                            <div class="col-md-6">
                                <input id="passwordUpdate" 
                                    type="password"
                                    class="passwordUpdate form-control" 
                                    name="passwordUpdate" 
                                    required>
                            </div>
                        </div>

                        <!-- Confirmar senha -->
                        <div class="form-group row">
                            <label for="passwordUpdate_confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirme a senha') }}</label>
                            <div class="col-md-6">
                                <input id="passwordUpdate_confirm" 
                                    type="password" 
                                    class="passwordUpdate_confirm form-control" 
                                    name="passwordUpdate_confirm" 
                                    required>
                            </div>
                        </div>

                        <!-- Data de nascimento -->
                        <div class="form-group row">
                            <label for="birthDateUpdate" class="col-md-4 col-form-label text-md-right">{{ __('Data de nascimento') }}</label>
                            <div class="col-md-6">
                                <input id="birthDateUpdate" 
                                    type="date" class="birthDateUpdate form-control" 
                                    name="birthDateUpdate" 
                                    required>
                            </div>
                        </div>

                        <!-- Tipo de usuário -->
                        <div class="form-group row">
                            <label for="roleUpdateSelect" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de usuário') }}</label>
                            <div class="col-md-6">
                                <select id="roleAddSelect" 
                                    class="roleUpdateSelect form-control" 
                                    name="roleUpdateSelect" 
                                    style="width: 100%" 
                                    required></select>                                    
                            </div>
                        </div>
                    </div>  
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" disabled>{{ __('Alterar') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<!-- DataTable Bootstrap 4 -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
<!-- DataTable Js Bootstrap 4 -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
    $(document).ready(function(){
        // Tabela de tipos de vacinas
        $('#userTable').DataTable({
            "language": {
                "decimal":        "",
                "emptyTable":     "Não há informações na tabela",
                "info":           "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty":      "Mostrando 0 a 0 de 0 entradas",
                "infoFiltered":   "(Filtrados de um total de _MAX_ entradas)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrar _MENU_ entradas",
                "loadingRecords": "Carregando...",
                "processing":     "Processando...",
                "search":         "Procurar:",
                "zeroRecords":    "Não foram econtrados registros correspondentes",
                "paginate": {
                    "first":      "Primeira",
                    "last":       "Última",
                    "next":       "Próxima",
                    "previous":   "Anterior"
                },
                "aria": {
                    "sortAscending":  ": ativar ordenação crescente da coluna",
                    "sortDescending": ": ativar ordenação decrescente da coluna"
                }
            }
        });

        // Select de tipo de usuário no registro de usuário
        // Tipos de usuário, sem formatação, vindos da UserController
        var roles = {!! json_encode($roles->toArray()) !!};

        // Array com os tipos de usuário formatados
        // para o select
        var rolesSelect = [];

        // Formatação para adequação ao select
        for (key in roles) {
            rolesSelect.push({id:roles[key].name, text:roles[key].name});
        };

        // Inicialização select de funções no formulário de registro de dose
        $('#roleAddSelect').select2({
            "data": rolesSelect,
            "language": {
                "noResults": function(){
                    return "Nenhum resultado foi encontrado...";
                }
            },
        });

        // // Inicialização select de nome da vacina no formulário de edição de dose
        // $('#roleUpdateSelect').select2({
        //     "data": vaccinesNameSelect,
        //     "language": {
        //         "noResults": function(){
        //             return "Nenhum resultado foi encontrado...";
        //         }
        //     },
        // });
        
        // Edição do tipos de vacina
        $('#userTable').on('click','.edit', function (event) {
            // Previne o redirecionamento do link            
            event.preventDefault();
            $.ajax({
                type: "GET",
                data: {
                    // Recupera o id do tipo de vacina que se quer modificar
                    userId: $(this).parent().find('.userId').val()
                },
                url: "{{ route('painel.updateUser_ajax')}}",                
                dataType : 'json',
                success: function(response) {
                    $("#nameUpdate").val(response.vaccine.name);
                    $("#vaccineIdUpdate").val(response.vaccine.id);
                    $("#vaccineUpdateModal").modal("show");
                },
                error: function(request, status, error) {
                    alert("Algum erro ocorreu na requisição, tente mais tarde.");
                }
            });
        });

    });
</script>
@endsection
