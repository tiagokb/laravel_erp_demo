<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class ViaCepService
{

    private string $baseUrl = "https://viacep.com.br/ws";

    /**
     * @throws RequestException
     */
    public function validate(int $cep)
    {
        if (!preg_match('/^[0-9]{8}$/', $cep)) return false;

        $response = Http::get($this->baseUrl . "/$cep/json")->throw()->json();

        if (isset($response['erro'])) {
            return false;
        }

        return true;
    }
}
