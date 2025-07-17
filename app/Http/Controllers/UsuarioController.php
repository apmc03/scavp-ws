<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    protected $reglasValidacion = [
        'rol_id' => 'required|integer|exists:roles,id',
        'usuario' => 'required|string|max:15',
        'correo' => 'required|string|email|max:50'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $response = User::get();
            if ($response) {
                return response()->json(['result' => $response, 'code' => '200']);
            } else
                return response()->json(['result' => "No hay registros", 'code' => '204']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'code' => '500']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'correo' => 'required|string|email',
                'password' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors(), 'code' => '400']);
            }

            return $this->validarCredenciales($request->correo, $request->password, 'login');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'code' => '500']);
        }
    }


    public function validarCredenciales(string $correo, string $password, string $tipo)
    {
        try {
            $response = User::where('correo', $correo)->first();

            if ($response && password_verify($password, $response->password)) {
                if($response->estado == '1'){
                    if ($tipo == 'validar') {
                        return response()->json(['code' => '200']);
                    } else {
                        $token = $response->createToken('accessToken')->plainTextToken;
                        return response()->json(['result' => $response, 'code' => '200', 'token' => $token]);
                    }
                } else {
                    return response()->json(['result' => "Usuario desactivado", 'code' => '401']);
                }
                
            }

            return response()->json(['result' => "Registro no encontrado", 'code' => '404']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'code' => '500']);
        }
    }


    public function generarPassword(string $requestPassword)
    {
        try {
            $password = $requestPassword;
            if($password == ''){
                $password = Str::random(10);
                $password .= rand(0, 9);
                $password .= Str::random(1, '!@#$%^&*()');
                $password = str_shuffle($password);
            }
            

            return response()->json(['code' => '200', 'result' => Hash::make($password)]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'code' => '500']);
        }
    }

    public function generarTokenPermanente($userId)
    {
        $user = User::findOrFail($userId);

        $token = $user->tokens()->create([
            'name' => 'token-permanente',
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => ['*'],
            'expires_at' => null,
        ]);

        return response()->json([
            'token' => $plainTextToken,
            'expires_at' => $token->expires_at,
        ]);
    }
    
}
