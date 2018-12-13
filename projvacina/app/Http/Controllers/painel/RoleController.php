<?php

namespace App\Http\Controllers\painel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Controller;
use App\Role;
use App\Role_user;
use App\Permission_role;
use App\Permission;


class RoleController extends Controller
{
    private $role;
    
    public function __construct(role $roles)
    {
        $this->role = $roles;                
    }
    
    public function index()
    {
        $roles = $this->role->all();
            //abort(403, 'Not Permissions Lists Post');

        $successMsg = null;
        // Se há uma mensagem de sucesso
        if (!empty(Input::get('successMsg'))) {
            $successMsg = Input::get('successMsg');
        }

        // Usuários do sistema junto com as suas funções
        $users = DB::table('users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->select('users.*', 'roles.name as role_name', 'roles.label as role_label')
                    ->get(); 

        // Funções junto com as suas permissões
        $roles = DB::table('roles')                    
                    ->join('permission_role', 'roles.id', '=', 'permission_role.role_id')
                    ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
                    ->select('roles.*', 'permissions.id as permission_id', 'permissions.name as permission_name', 'permissions.label as permission_label')                    
                    ->get()
                    ->groupBy('name', 'label');

        // Inicialização do vetor de reorganização das funções
        $rolesTable = [];

        // Reorganização dos dados
        foreach ($roles as $key1=>$rolePermission){
            foreach ($rolePermission as $key2=>$permission) {
                $rolesTable[$key1]['name'] = $rolePermission[$key2]->name;
                $rolesTable[$key1]['label'] = $rolePermission[$key2]->label;
                $rolesTable[$key1]['id'] = $rolePermission[$key2]->id;
                $rolesTable[$key1]['permissions'][$key2] =    array(
                                                                'id' => $permission->permission_id, 
                                                                'name' => $permission->permission_name,
                                                                'label' => $permission->permission_label
                                                            );                
            }
        }
        
        // Permissões existentes
        $permissions = DB::table('permissions')                    
                        ->select('name', 'label')                    
                        ->get();
                        
        return view('painel.roles.index', array('roles' => $rolesTable, 
                                                'successMsg' => $successMsg, 
                                                'permissions' => $permissions));
    }

    public function store(Request $request) 
    {            
        // Persistência do perfil
        $role = new Role;
        $role->name = $request->nameAdd;
        $role->label = $request->descriptionAdd;
        $role->save();

        // Persistência das relações de permissão e perfil de usuário
        // Parâmetros do form
        $parameters = $request->all();
        foreach($parameters as $key=>$parameter) {
            // Apenas as permissões são tratadas
            if($key == '_token' || $key == 'nameAdd' || $key == 'descriptionAdd') {
                continue;
            }
            $permissionRole = new Permission_role;
            $permissionRole->timestamps = false;
            $permissionRole->permission_id = (DB::table('permissions')->where('name', '=', $parameter)->first())->id;
            $permissionRole->role_id = $role->id;
            $permissionRole->save();
        }

        // Após o perfil de usuário ser adicionado
        // retorna para a página de usuários por meio do index
        // com uma mensagem de confirmação
        $successMsg = 'Perfil de usuário cadastrado com sucesso!'; 
        return redirect()->action(
            'painel\RoleController@index', ['successMsg' => $successMsg]
        );     
    }

    public function updateRole_ajax()
    {
        // Id do perfil de usuário selecionado
        $roleId = Input::get('roleId');
        $role = Role::findOrFail($roleId);
        
        $permissions =  DB::table('roles')
                            ->join('permission_role', 'permission_role.role_id', '=', 'roles.id')
                            ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
                            ->select('permissions.name as permission_name')
                            ->where('roles.id', '=', $roleId)
                            ->get();

        return response()->json(array(  'role' => $role, 
                                        'permissions' => $permissions));  
    }

    public function update(Request $request)
    {
        // Atualização do usuário
        $role = Role::findOrFail($request->roleIdUpdate);
        $role->name = $request->nameUpdate;
        $role->label = $request->descriptionUpdate;
        $role->save();

        // Permissões antigas
        $oldPermissions = DB::table('roles')
                            ->join('permission_role', 'permission_role.role_id', '=', 'roles.id')
                            ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
                            ->select('permission_role.id as permission_role_id')
                            ->where('roles.id', '=', $request->roleIdUpdate)
                            ->get();

        // Remoção das antigas relações entre permissão e perfil de usuário
        foreach($oldPermissions as $oldPermission) {
            $permission_role = Permission_role::findOrFail($oldPermission->permission_role_id);
            $permission_role->delete();
        }
 
        // Adição das novas relações de permissão e perfil de usuário
        $parameters = $request->all();
        foreach($parameters as $key=>$parameter) {
            // Apenas as permissões são tratadas
            if($key == '_token' || $key == 'nameUpdate' || $key == 'descriptionUpdate' || $key == 'roleIdUpdate') {
                continue;
            }
            $permissionRole = new Permission_role;
            $permissionRole->timestamps = false;
            $permissionRole->permission_id = (DB::table('permissions')->where('name', '=', $parameter)->first())->id;
            $permissionRole->role_id = $role->id;
            $permissionRole->save();
        }

        // Após o perfil de usuário ser atualizado
        // retorna para a página de usuários por meio do index
        // com uma mensagem de confirmação
        $successMsg = 'Perfil de usuário atualizado com sucesso!'; 
        return redirect()->action(
            'painel\RoleController@index', ['successMsg' => $successMsg]
        );  
    }

    public function destroy(Request $request) 
    {
        // Alteração da tabela role_user (perfil deletado torna-se usuário comum) 
        $roles_user = DB::table('role_user')
                        ->where('role_id', '=', $request->roleId)
                        ->get();
        foreach ($roles_user as $role_user) {
            $role_user = Role_user::findOrFail($role_user->id);
            $role_user->timestamps = false;
            // Alteração para usário comum (adm -> id:1, usuario -> id:2 e profissionl_saude -> id:3)
            $role_user->role_id = 2;
            $role_user->save();
        }

        // Permissões relacionadas ao perfil
        $permissions = DB::table('roles')
                            ->join('permission_role', 'permission_role.role_id', '=', 'roles.id')
                            ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
                            ->select('permission_role.id as permission_role_id')
                            ->where('roles.id', '=', $request->roleId)
                            ->get();

        // Remoção das relações entre permissão e perfil de usuário
        foreach($permissions as $permissions) {
            $permission_role = Permission_role::findOrFail($permissions->permission_role_id);
            $permission_role->delete();
        }

        // Após o perfil ser excluído
        // retorna para a página de perfis por meio do index
        // com uma mensagem de confirmação
        $successMsg = 'Perfil excluído com sucesso!'; 
        return redirect()->action(
            'painel\RoleController@index', ['successMsg' => $successMsg]
        );          
    }

    public function permissions($id)
    {
        //Recupera o role
        $role = $this->role->find($id);
        
        //recuperar permissões
        $permissions = $role->permissions()->get();
        
        return view('painel.roles.permissions', compact('role', 'permissions'));
    }
}
