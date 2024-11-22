<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Hash;
use Illuminate\Http\Request;
use Validator;
use Log;

class AuthController extends Controller
{
    //Registra nuovo utente
    public function register(Request $request){
        try{
            $validateData = Validator::make($request->all(),[
                'name' => 'required|string|max:55',
                'email'=> 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ],[
                'name.required' => 'Inserire un nome',
                'name.string' => 'Non puoi utilizzare caratteri speciali',
                'name.max' => 'Il nome non può superare i 55 caratteri',
                'email.required' => 'Inserire un indirizzo email',
                'email.string' => 'Non puoi utilizzare caratteri speciali',
                'email.email' => 'Inserire un indirizzo email valido',
                'email.unique' => 'Indirizzo email già registrato',
                'password.required' => 'Inserire una password',
                'password.min' => 'La password deve contenere almeno 8 caratteri',
            ]);

            if(!$validateData->fails()){
                $user = Users::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                ]);

                return response()->json([
                    'message' => 'Utente registrato correttamente'

                ],201);
            }else{
                return response()->json([
                    'message' => 'Dati di registrazione incompleti o non validi: '.$validateData->errors(),
                ], 204);
            }

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Errore nella registrazione dell\'utente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request){
        try{
            $validate = Validator::make($request->all(),[
                'email' => 'required|string|max:55',
                'password' => 'required|string|min:8',
            ],[
                'email.required' => 'Inserire un indirizzo email',
                'email.string' => 'Non puoi utilizzare caratteri speciali',
                'password.required' => 'Inserire una password',
                'password.min' => 'La password deve contenere almeno 8 caratteri',
            ]);
            if (!$validate->fails()){
                $user = Users::where('email', $request['email'])->get();
                Log::info($user->password);
                if(!$user || Hash::check($request['password'], $user->password)){
                    return response()->json([
                        'message'=>'Username o password non corretti',
                    ],404);
                }

                $user->tokens()->delete();

                return response()->json([
                    'status'=>'success',
                    'message'=> 'Utente loggato correttamente',
                    'name'=> $user->name,
                    'token' => $user->createToken('token')->plainTextToken,
                ]);
            }else{
                return response()->json([
                    'message' => 'Dati di login incompleti o non validi',
                    'error' => $validate->errors()
                ], 204);
            }

        }catch(\Exception $e){
            return response()->json([
                'message'=> 'Errore nel login'. $e->getMessage(),
            ],500);
        }
    }

    public function logout(Request $request){
        try{
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Logout effettuato correttamente'
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Errore nel logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
