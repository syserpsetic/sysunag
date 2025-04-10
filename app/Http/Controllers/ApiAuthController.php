<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Exception;

class ApiAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.auth.login', [
            'layout' => 'base'
        ]);
        //return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        //if ($request->coordenadas){
            $response = Http::post(env('API_BASE_URL_ZETA').'/api/auth/login', [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                //'platform' => 'SYS',
                'coordenadas' => $request->coordenadas
            ]);
        // } else {
        //     throw new Exception('¡Acceso al sistema denegado! Debe Permitir la Ubicación.');
        // }
        
        if ($response->status() === 200) {
            $userData = $response->json();
            $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $user = User::firstOrNew([$fieldType => $request->input('email')]);
            $user->name = $userData['name'];
            $user->password = '0';
            $user->save();
            Session::put('token', $userData['token']);
            auth()->login($user);
            if($userData['username'] == '22A0000'){
                return redirect("/setic/malla_validacion");
            }
            return redirect('/');
        } elseif($response->status() === 403) {
            throw new Exception('¡Acceso al sistema denegado!');
        } else {
            return redirect('/login')->withErrors(['error' => 'Usuario no encontrado']);
        }
    }

    public function logout()
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->post(env('API_BASE_URL_ZETA').'/api/auth/logout');


        if($response->status() === 200){
            session()->flush();
            Auth::logout();
            return redirect('login');
        }
        
    }

    /*Funcion que captura los datos y los maneja*/
    public function handleGoogleCallback(Request $request)
{
    throw new Exception('Hola');
    $response = Http::get(env('API_BASE_URL_ZETA').'/api/auth/google/callback');
    //throw new Exception('Hola');
    if ($response->successful()) {
        $data = $response->json();

        // Guarda el token en el cliente (por ejemplo, en localStorage o cookies)
        session(['access_token' => $data['access_token']]);

        return redirect('/');
    }

    return redirect('/login')->with('error', 'Error al autenticar con Google.');
}
}
