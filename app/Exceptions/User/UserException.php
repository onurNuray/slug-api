<?php

namespace App\Exceptions\User;

use Exception;

class UserException extends Exception
{
    public function render($request)
    {       
        return response()->json([
            "status" => false,
            "message" => $this->getMessage()
        ],$this->code);
    }
}
