<?php

namespace App\Services\FakerStoreApi;

use Illuminate\Support\Facades\Http;

class FakerStoreApi implements FakerStoreApiInterface
{
    public function all()
    {
        $response = Http::fakerStore()->get('/');

        if ($response->failed()) {
            throw new \Exception('Não foi possível pegar os produtos');
        }

        return $response->json();
    }

    public function getById($id)
    {
        $response = Http::fakerStore()->get("/$id");

        if ($response->failed()) {
            throw new \Exception('Não foi possível pegar o produto');
        }

        if ($response->json() === null) {
            throw new \Exception('Produto não encontrado');
        }

        return $response->json();
    }
}
