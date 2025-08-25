<?php

namespace App\Http\Controllers;

use App\Models\Acceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccesoController extends Controller
{
    protected $reglasValidacion = [
        'vehiculo_id' => 'integer|exists:vehiculos,vehiculo_id',
        'visitante' => 'required|string|max:50',
        'placa' => 'required|string|max:50',
        'foto_ingreso' => 'required|string|max:50'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $response = Acceso::all()
            ->orderBy('fecha_ingreso', 'desc')
            ->get();

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
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $reglasEspecificas = $this->reglasValidacion;
            $validator = Validator::make($request->all(), $reglasEspecificas);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors(), 'code' => '400']);
            }

            $salida = Acceso::where('placa', $request->placa)->where('fecha_salida', null)->first();
            
            if ($salida) {
                $salida->fecha_salida = date('Y-m-d H:i:s');
                $salida->foto_salida = $request->foto_ingreso;

                $salida->update();
                return response()->json(['result' => "Dato Actualizado", 'code' => '200']);
            }

            $data = new Acceso();
            $data->fill($request->all());
            if (!$request->visitante == 1) {
                $data->vehiculo_id = 1;
            }
            $data->fecha_ingreso = date('Y-m-d H:i:s');
            $data->fecha_salida = null;
            $data->foto_salida = null;
            $data->save();
            return response()->json(['result' => "Dato Registrado", 'code' => '200']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'code' => '500']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'acceso_id' => 'required|integer|exists:accesos,acceso_id']);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors(), 'code' => '400']);
            }

            $data = Acceso::find($request->acceso_id);
            $data->fill($request->all());
            $data->fecha_salida = date('Y-m-d H:i:s');
            $data->update();
            return response()->json(['result' => "Dato Actualizado", 'code' => '200']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'code' => '500']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function actualizarVisitante(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'acceso_id' => 'required|integer|exists:accesos,acceso_id',
                'persona' => 'required|string|max:100']);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors(), 'code' => '400']);
            }

            $data = Acceso::find($request->acceso_id);
            
            if ($data) {
                $data->visitante = $request->persona;
                $data->update();

                return response()->json(['result' => "Dato Actualizado", 'code' => '200']);
            } else
                return response()->json(['result' => "No existe el acceso", 'code' => '204']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'code' => '500']);
        }
    }
}
