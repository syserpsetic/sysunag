<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\User;
use Session;

class googleController extends Controller
{
    /*Funcion que captura los datos y los maneja*/
    public function handleGoogleCallback(Request $request)
    { 
        $email = $request->input('email');
        $name = $request->input('name');
        $token = $request->input('token');
        $response_code = $request->input('response_code');
        $msg = $request->input('msg');
        //throw new Exception($email);
        if($response_code == 200){
            $user = User::firstOrNew(['email' => $email]);
            $user->name = $name;
            $user->password = '0';
            $user->save();
            Session::put('token', $token);
            auth()->login($user);
            if($email == 'jdoe22A0000@unag.edu.hn'){
                return redirect("/setic/malla_validacion");
            }
            return redirect('/');
        }else{
            return redirect("/login")->withErrors([
                'msg' => $msg
            ]);
        }
    }
}
