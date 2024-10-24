<?php

namespace App\Exceptions;

use Exception;

class GeneralException extends Exception
{
    public function __construct($message = 'Something went wrong', $code = 500)
    {
        $this->message = $message;
        $this->code = $code;

        parent::__construct($this->message, $this->code);
    }

    public function render($request)
    {
        return response()->json([
            'statusCode' => $this->code,
            'message' => $this->message
        ], $this->code);
    }
}
