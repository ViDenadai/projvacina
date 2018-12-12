@extends('painel.templates.template')

@section('content')
<div class="container">
    @if(!empty($successMsg))
    <div class="alert alert-success" role="alert"><i class="fas fa-check"></i> {{ $successMsg }} </div>
    @endif
    <br>
    <h1 class="title">
        <div class="d-flex">
            <div class="mr-auto p-2"><b>Todos os perfis de usuário</b></div>
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
                            {{ $permission['label'] }}
                            <br>
                        @endforeach
                    </td>

                    <!-- Ações(Editar/Excluir) -->
                    <td>
                        <!-- A opção de editar só aparece para os tipos de usuário além do
                            padrão(adm -> id:1, usuario -> id:2 e profissionl_saude -> id:3) -->
                        @if ($role['id'] > 3)  
                            <a class="edit" href="#" title="Editar">
                                <i class="fa fa-pencil-square-o"></i>
                                <input type="hidden" class="roleId" name="roleId" value="{{ $role['id'] }}">
                            </a>
                        @else    
                            <button class="delete2" disabled>
                                <i class="fa fa-pencil-square-o"></i>                                                    
                            </button>
                        @endif                  
                        <form style="display: inline-block;" method="POST" 
                            action="{{ route('painel.deleteRole') }}"                                                        
                            data-toggle="tooltip" data-placement="top"
                            title="Excluir" 
                            onsubmit="return confirm('Caso você exclua esse perfil de usuário todos os usuários relacionados à essa função serão transformados em usuário comum. Você deseja excluir?')">
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

    <!-- Modal de adição de perfil de usuário -->
    <div class="modal fade" id="roleAddModal" role="dialog" aria-labelledby="roleAddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form class="" 
                    method="POST" 
                    action="{{ route('painel.storeRole') }}" 
                    aria-label="{{ __('formRoleUser') }}" 
                    id="formRoleUser">               
                    
                    <!-- Modal header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel"><b>Adicionar perfil de usuário</b></h5>
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
                            <label for="nameAdd" class="col-md-4 col-form-label text-md-right">{{ __('Nome do perfil') }}</label>
                            <div class="col-md-6">                    
                                <input id="nameAdd" 
                                    type="text" 
                                    class="nameAdd form-control" 
                                    name="nameAdd" 
                                    value="{{ old('nameAdd') }}" 
                                    placeholder="Administrador"
                                    required autofocus>
                            </div>
                        </div>
                        
                        <!-- Descrição do perfil -->
                        <div class="form-group row">
                            <label for="descriptionAdd" class="col-md-4 col-form-label text-md-right">{{ __('Descrição do perfil') }}</label>
                            <div class="col-md-6">                    
                                <input id="descriptionAdd" 
                                    type="text" 
                                    class="descriptionAdd form-control" 
                                    name="descriptionAdd" 
                                    value="{{ old('descriptionAdd') }}"
                                    placeholder="Administrador do sistema" 
                                    required autofocus>
                            </div>
                        </div>

                        <!-- Permissões -->
                        <div class="form-group row">
                            <label for="permissionAdd" class="col-md-4 col-form-label text-md-right">{{ __('Permissões do usuário') }}</label>
                            <div class="col-md-6"> 
                                @foreach ($permissions as $key=>$permission)
                                    <!-- A primeira permissão é sempre marcada -->
                                    @if($key == 0)
                                        <div class="form-check">
                                            <input class="form-check-input fade5" 
                                                type="checkbox"
                                                name="{{ $permission->name }}" 
                                                value="{{ $permission->name }}"
                                                onclick="return false;" 
                                                checked>
                                            <label class="form-check-label fade5" for="gridCheck1">
                                            {{ $permission->label }}
                                            </label>
                                        </div>
                                    @else
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                type="checkbox" 
                                                name="{{ $permission->name }}"
                                                value="{{ $permission->name }}">
                                            <label class="form-check-label" for="gridCheck1">
                                            {{ $permission->label }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
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

    <!-- Modal de edição de perfil de usuário -->
    <div class="modal fade" id="roleUpdateModal" role="dialog" aria-labelledby="roleUpdateModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('painel.updateRole') }}" aria-label="{{ __('formUpdateRole') }}">
                    <!-- Modal header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUpdateLabel"><b>Alterar informações do perfil de usuário</b></h5>
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
                            <label for="nameUpdate" class="col-md-4 col-form-label text-md-right">{{ __('Nome do perfil') }}</label>
                            <div class="col-md-6">                    
                                <input id="nameUpdate" 
                                    type="text" 
                                    class="nameUpdate form-control" 
                                    name="nameUpdate" 
                                    value="{{ old('nameUpdate') }}"
                                    required autofocus>
                            </div>
                        </div>
                        
                        <!-- Descrição do perfil -->
                        <div class="form-group row">
                            <label for="descriptionUpdate" class="col-md-4 col-form-label text-md-right">{{ __('Descrição do perfil') }}</label>
                            <div class="col-md-6">                    
                                <input id="descriptionUpdate" 
                                    type="text" 
                                    class="descriptionUpdate form-control" 
                                    name="descriptionUpdate" 
                                    value="{{ old('descriptionUpdate') }}"
                                    placeholder="Administrador do sistema" 
                                    required autofocus>
                            </div>
                        </div>

                        <!-- Permissões -->
                        <div class="form-group row">
                            <label for="permissionUpdate" class="col-md-4 col-form-label text-md-right">{{ __('Permissões do usuário') }}</label>
                            <div class="col-md-6"> 
                                @foreach ($permissions as $key=>$permission)                                    
                                    @if($key == 0)
                                        <!-- A primeira permissão é sempre marcada -->
                                        <div class="form-check">
                                            <input class="form-check-input fade5" 
                                                type="checkbox"
                                                id="{{ $permission->name }}_update"
                                                name="{{ $permission->name }}" 
                                                value="{{ $permission->name }}"
                                                onclick="return false;" 
                                                checked>
                                            <label class="form-check-label fade5" for="gridCheck1">
                                            {{ $permission->label }}
                                            </label>
                                        </div>
                                    @else
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                type="checkbox" 
                                                id="{{ $permission->name }}_update"
                                                name="{{ $permission->name }}"
                                                value="{{ $permission->name }}">
                                            <label class="form-check-label" for="gridCheck1">
                                            {{ $permission->label }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Id do usuário para o update -->
                        <input type="hidden" class="roleIdUpdate" id="roleIdUpdate" name="roleIdUpdate" value=''>
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
        
        // Edição do usuário
        $('#roleTable').on('click','.edit', function (event) {
            // Previne o redirecionamento do link            
            event.preventDefault();

            // Id do perfil é posto no form de update de usuário
            $("#roleIdUpdate").val($(this).parent().find('.roleId').val());
            $.ajax({
                type: "GET",
                data: {
                    // Recupera o id do tipo de vacina que se quer modificar
                    roleId: $(this).parent().find('.roleId').val()
                },
                url: "{{ route('painel.updateRole_ajax')}}",                
                dataType : 'json',
                success: function(response) {
                    // Valores antigos do perfil de usuário
                    $("#nameUpdate").val(response.role.name);
                    $("#descriptionUpdate").val(response.role.label);

                    // Loop que marca todas as permissões que o perfil de usuário possui
                    for (key in response.permissions) {
                        var permission_name = response.permissions[key].permission_name;
                        $('#' + permission_name + '_update').attr("checked", true);
                    };                
                    $("#roleUpdateModal").modal("show");
                },
                error: function(request, status, error) {
                    alert("Algum erro ocorreu na requisição, tente mais tarde.");
                }
            });
        });

    });
</script>
@endsection
