<?php

namespace App\Services\FakerStoreApi;

interface FakerStoreApiInterface
{
    public function all();
    public function getById($id);
}
