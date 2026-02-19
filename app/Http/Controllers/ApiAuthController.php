<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Crypt;

class ApiAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showLoginForm()
    {
        return view('pages.auth.login', [
            'layout' => 'base'
        ]);
        //return view('auth.login');
    }

    public function showLoginFormEgresados()
    {
        // return view('pages.auth.login', [
        //     'layout' => 'base'
        // ]);
        return view('sys.egresados.login_egresados', [
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

        $userData = $response->json();
        //throw new Exception($encryptedId);
        if($response->status() === 403 && $userData['changePass'] == true){
            $encryptedId = Crypt::encryptString($userData['id_usuario']);
            return view('pages.auth.changepassword', [
                    'url' => '/change_password_view',
                    'data' => [
                        'mensaje' => $userData['mensaje'] ,
                        'encryptedId' => $encryptedId
                    ]
                ]);   
        }
        
        if ($response->status() === 200) {
            $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $user = User::firstOrNew([$fieldType => $request->input('email')]);
            $user->name = $userData['name'];
            $user->password = '0';
            $user->email = $userData['email'];
            $user->save();
            Session::put('token', $userData['token']);
            Session::put('bienvenida', $userData['bienvenida']);
            Session::put('mensaje_egresado', $userData['mensaje_egresado']);
            Session::put('foto', $userData['foto']);
            auth()->login($user);
            if($userData['username'] == '22A0000'){
                return redirect("/setic/malla_validacion");
            }
            return redirect('/');
        } elseif($response->status() === 403) {
            throw new Exception('¡Acceso al sistema denegado!');
        } else {
            return redirect('/login')->withErrors(['error' => 'Usuario o contraseña incorrectos']);
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

    public function change_password_view()
    {
        return view('pages.auth.changepassword');
        
    }

     public function change_password(Request $request)
    {
        $usuarioId = Crypt::decryptString($request->encryptedId);

        $response = Http::post(env('API_BASE_URL_ZETA').'/api/auth/change_password', [
                'encryptedId' => $usuarioId,
                'password_old' => $request->input('password_old'),
                'password_new' => $request->input('password_new'),
                'password_verify' => $request->input('password_verify')
            ]);

        $estatus = $response['estatus'];
        $msgSuccess = $response['msgSuccess'];
        $msgError = $response['msgError'];

        if($response->status() === 200 && $estatus == true){
            return redirect('/');
        }else{
            return view('pages.auth.changepassword', [
                    'url' => '/change_password_view',
                    'data' => [
                        'mensaje' => $msgError,
                        'encryptedId' => $request->encryptedId
                    ]
                ]);
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
