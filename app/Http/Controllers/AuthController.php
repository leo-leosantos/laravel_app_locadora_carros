<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credenciais = $request->all(['email', 'password']);


        // dd($credenciais);
        //authentication

        $token =  auth('api')->attempt($credenciais);

        if ($token) { //usuario autenticado com sucesso
            return response()->json(['token' => $token]);
        } else { //erro de usuario ou senha
            return response()->json(['erro' => 'Usuário ou senha invalido'], 403);
            //error 403 = forbidden -> proibido (login invalido)
            //error 401 = Unauthorized -> não autorizado
        }

        return 'login';
    }
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['msg'=>'Logout realizado com sucesso']);

    }

    public function refresh()
    {
        $token = auth('api')->refresh();

        return response()->json(['token' => $token]);
    }
    public function me()
    {
        return response()->json(auth()->user());
    }
}
