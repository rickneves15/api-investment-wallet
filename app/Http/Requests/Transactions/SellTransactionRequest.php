<?php

namespace App\Http\Requests\Transactions;

use App\Http\Requests\Helpers\ExceptionValidation;
use Illuminate\Foundation\Http\FormRequest;

class SellTransactionRequest extends FormRequest
{
    use ExceptionValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'assetId' => ['required', 'exists:assets,id'],
            'date' => ['required', 'date'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
