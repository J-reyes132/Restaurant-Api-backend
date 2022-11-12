<?php

namespace App\Exceptions;

use Exception;
use App\Tools\ResponseCodes;

class NameOnUse extends Exception
{
    public function render()
    {
        return response()->json(['status' => 'error', 'message' => 'Nombre ya se encuentra en uso'], ResponseCodes::UNPROCESSABLE_ENTITY);
    }
}