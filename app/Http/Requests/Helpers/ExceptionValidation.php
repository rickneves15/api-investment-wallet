<?php

namespace App\Http\Requests\Helpers;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ExceptionValidation
{
  protected function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json([
      'statusCode' => 422,
      'errors' => $validator->errors(),
    ], 422));
  }
}
