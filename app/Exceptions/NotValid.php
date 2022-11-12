<?php

namespace App\Exceptions;

use Exception;
use App\Tools\ResponseCodes;

class NotValid extends Exception
{
    public function render()
    {
        return response()->json(['status' => 'error', 'message' => 'Numero Identificacion no valido'], ResponseCodes::UNPROCESSABLE_ENTITY);
    }
}