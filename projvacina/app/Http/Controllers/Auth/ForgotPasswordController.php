<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * Verifica se o e-mail existe antes de submeter o e-mail de recuperação
     *
     * @return   boolean    $exists      Se for true existe o e-mail, caso contrário, é false 
     *
     */
    public function forgotPass_email_ajax()
    {
        // Email digitado
        $email = Input::get('email');
        $user = DB::table('users')
                    ->where('email', '=', $email)
                    ->get();
        // Se existe o e-mail existe
        if ($user != NULL) {
            $exists = true;
        } else {
            $exists = false;
        }
        return response()->json(array('exists' => $exists));  
    }

}
