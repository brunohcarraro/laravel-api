<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6'
        ], [
            'name.required' => 'Por favor, preencha seu nome.',
            'email.required' => 'Por favor, preencha seu email.',
            'email.email' => 'Preencha um e-mail válido',
            'password.required' => 'Por favor, digite uma senha',
            'password.min' => 'A senha deve conter no mínimo :min caracteres',
            'password.confirmed' => 'As senhas não conferem'
        ]);
       
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        return $user;

    }

    // public function register(Request $request)
    // {
    //     $fields = $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|string|confirmed|min:6'
    //     ], [
    //         'name.required' => 'Por favor, preencha seu nome.',
    //         'email.required' => 'Por favor, preencha seu email.',
    //         'email.email' => 'Preencha um e-mail válido',
    //         'password.required' => 'Por favor, digite uma senha',
    //         'password.min' => 'A senha deve conter no mínimo :min caracteres',
    //         'password.confirmed' => 'As senhas não conferem'
    //     ]);
       
    //     $user = User::create([
    //         'name' => $fields['name'],
    //         'email' => $fields['email'],
    //         'password' => bcrypt($fields['password'])
    //     ]);

    //     $token = $user->createToken('myapptoken')->plainTextToken;

    //     $response = [
    //         'user' => $user,
    //         'token' => $token
    //     ];

    //     return response($response, 201);

    // }

    public function login(Request $request)
    {
    	$fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ], [
            'email.required' => 'Por favor, preencha seu email.',
            'email.email' => 'Preencha um e-mail válido',
            'password.required' => 'Por favor, digite sua senha',
        ]);
       
    	$user = User::where('email', $fields['email'])->first();

    	if (!$user || !Hash::check($fields['password'], $user->password)) {
    		return response([
    			'message' => 'Usuário ou senha incorretos.'
    		], 401);
    	}


    	$token = $user->createToken('myapptoken')->plainTextToken;

    	$response = [
    		'user' => $user,
    		'token' => $token
    	];

    	return response($response, 201);

    }

    public function logout(Request $request){
    	auth()->user()->tokens()->delete();

    	return [
    		'message' => "Usuário deslogado."
    	];
    }

}
