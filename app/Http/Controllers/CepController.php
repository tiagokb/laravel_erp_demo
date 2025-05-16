<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CepController extends Controller
{
    public function validate(Request $request): JsonResponse
    {
        $cep = $request->input('cep');

        if (!preg_match('/^\d{5}-?\d{3}$/', $cep)) {
            return response()->json(['valid' => false, 'message' => 'CEP inválido']);
        }

        // Exemplo: verifica se existe no banco
        $exists = DB::table('ceps')->where('cep', $cep)->exists();

        return response()->json([
            'valid' => $exists,
            'message' => $exists ? 'CEP válido' : 'CEP não encontrado'
        ]);
    }
}
