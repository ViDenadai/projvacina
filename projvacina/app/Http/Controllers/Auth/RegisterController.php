<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\User;
use App\Role_user;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nascimento'=> $data['nascimento'],
        ]);
    }

    /**
     * Registra um novo usuário da plataforma.
     *
     * @param    Request     $request           Contém as informações do novo registro
     * @return   string      $successMsg        Mensagem de sucesso do registro
     *
     */
    protected function register(Request $request)
    {        
        // Persistência do usuário
        $user = new User;
        $user->name = $request->nameAdd;
        $user->email = $request->emailAdd;
        $user->password = Hash::make($request->passwordAdd);
        $user->nascimento = $request->birthDate;
        $user->save();

        // Persistência do tipo de usuário (Usuário comum -> role_id: 2)
        $role_user = new Role_user;
        $role_user->timestamps = false;
        $role_user->user_id = $user->id;
        $role_user->role_id = 2;       
        $role_user->save(); 

        // Após o usuário ser registrado
        // retorna uma mensagem de sucesso
        $successMsg = 'Usuário registrado com sucesso!'; 
        return response()->json(array('successMsg' => $successMsg)); 
    }
}
