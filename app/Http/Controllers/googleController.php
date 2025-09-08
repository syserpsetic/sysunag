<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use Session;

class googleController extends Controller
{
    /*Funcion que captura los datos y los maneja*/
    public function handleGoogleCallback(Request $request, $email, $token, $name)
    { 
            $user = User::firstOrNew(['email' => $email]);
            $user->name = $name;
            $user->password = '0';
            $user->save();
            Session::put('token', $token);
            auth()->login($user);
            if($userData['username'] == '22A0000'){
                return redirect("/setic/malla_validacion");
            }
            return redirect('/');
    }
}
