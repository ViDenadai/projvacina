@extends('painel.templates.template')

@section('content')
<div class="container">
    @if(!empty($successMsg))
    <div class="alert alert-success" role="alert"><i class="fas fa-check"></i> {{ $successMsg }} </div>
    @endif
    <br>
    <h1 class="title">
        <div class="d-flex">
            <div class="mr-auto p-2"><b>Todos os tipos de usuário</b></div>
                <div class="ml-auto p-2">
                    <a href="/painel/newDose" data-toggle="modal" data-target="#roleAddModal">
                        <b><i class="far fa-plus-square add"></i></b>
                    </a>  
                </div>            
        </div>
    </h1>
    <hr>
    <table id="roleTable" class="table table-striped" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Permissões</th>
                <th width="100px">Ações</th>   
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role['name'] }}</td>
                    <td>{{ $role['label'] }}</td>

                    <!-- Função -->
                    <td>
                        @foreach($role['permissions'] as $permission)
                            {{-- $permission['id'] --}}
                            {{-- $permission['name'] --}}
                            <i class="fas fa-check" style="color:green"></i>                            
                            {{$permission['label']}}
                            <br>
                        @endforeach
                    </td>

                    <!-- Ações(Editar/Excluir) -->
                    <td>
                        <a class="edit" href="#" title="Editar">
                            <i class="fa fa-pencil-square-o"></i>
                            <input type="hidden" class="roleId" name="roleId" value="{{ $role['id'] }}">
                        </a>                      
                        <form style="display: inline-block;" method="POST" 
                            action="{{ route('painel.deleteRole') }}"                                                        
                            data-toggle="tooltip" data-placement="top"
                            title="Excluir" 
                            onsubmit="return confirm('Caso você exclua esse tipo de usuário todos os usuários relacionados à essa função serão transformados em usuário comum. Você deseja excluir?')">
                            <!-- A opção de remover só aparece para os tipos de usuário além do
                                padrão(adm -> id:1, usuario -> id:2 e profissionl_saude -> id:3) -->
                            @if ($role['id'] > 3)                                
                                <input type="hidden" class="roleId" name="roleId" value="{{ $role['id'] }}">
                                {{-- method_field('DELETE') --}}{{ csrf_field() }}                                                
                                <button type="submit" class="delete">
                                    <i class="fa fa-trash"></i>                                                    
                                </button>
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
                        <h5 class="modal-title" id="modalAddLabel"><b>Adicionar usuário</b></h5>
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
                        <h5 class="modal-title" id="modalUpdateLabel"><b>Alterar informações do usuário</b></h5>
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
                                <select id="roleUpdateSelect" 
                                    class="roleUpdateSelect form-control" 
                                    name="roleUpdateSelect" 
                                    style="width: 100%" 
                                    required></select>                                    
                            </div>
                        </div>

                        <!-- Id do usuário para o update -->
                        <input type="hidden" class="userIdUpdate" id="userIdUpdate" name="userIdUpdate" value=''>
                    </div>  
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">{{ __('Alterar') }}</button>
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
        $('#roleTable').DataTable({
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
        
        // // Edição do usuário
        // $('#userTable').on('click','.edit', function (event) {
        //     // Previne o redirecionamento do link            
        //     event.preventDefault();

        //     // Id da dose é posto no form de update de usuário
        //     $("#userIdUpdate").val($(this).parent().find('.userId').val());
        //     $.ajax({
        //         type: "GET",
        //         data: {
        //             // Recupera o id do tipo de vacina que se quer modificar
        //             userId: $(this).parent().find('.userId').val()
        //         },
        //         url: "{{ route('painel.updateUser_ajax')}}",                
        //         dataType : 'json',
        //         success: function(response) {
        //             // Valores antigos do usuário
        //             $("#nameUpdate").val(response.user.name);
        //             $("#emailUpdate").val(response.user.email);
        //             $("#birthDateUpdate").val(response.user.nascimento);                    
        //             $("#roleUpdateSelect").val(response.userRole.role_name);
        //             $('#roleUpdateSelect').trigger('change');                 
        //             $("#userUpdateModal").modal("show");
        //         },
        //         error: function(request, status, error) {
        //             alert("Algum erro ocorreu na requisição, tente mais tarde.");
        //         }
        //     });
        // });

    });
</script>
@endsection
