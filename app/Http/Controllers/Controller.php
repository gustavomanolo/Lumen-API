<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    public function crearRespuesta($datos, $codigo)
    {
    	return response()->json(['data' => $datos], $codigo);
    }
    
    public function crearRespuestaError($mensaje, $codigo)
    {
    	return response()->json(['message' => $mensaje, 'code' => $codigo], $codigo);
    }

    //-> *** To prevent "automatic redirect" from Lumen in case that the request is not valid
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        return $this->crearRespuestaError($errors, 422);
    }

}
