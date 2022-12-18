<?php

namespace App\Exceptions\Login;

use Exception;

class LoginException extends Exception
{
    public function render($request)
    {       
        return response()->json([
            "status" => false,
            "message" => $this->getMessage()
        ],$this->code);
    }
}
