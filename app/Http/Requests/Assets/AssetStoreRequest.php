<?php

namespace App\Http\Requests\Assets;

use App\Enums\AssetTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssetStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'purchase_date' => ['required', 'date'],
            'quantity' => ['required', 'integer'],
            'quote' => ['required', 'numeric'],
            'type' => ['required', Rule::enum(AssetTypeEnum::class)],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'statusCode' => 422,
            'errors' => $validator->errors(),
        ], 422));
    }
}
