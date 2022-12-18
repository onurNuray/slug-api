<?php

namespace App\Exceptions\Slug;

use Exception;

class SlugException extends Exception
{
    public function render($request)
    {
        return response()->json([
            "status" => false,
            "message" => $this->getMessage()
        ], $this->code);
    }
}
