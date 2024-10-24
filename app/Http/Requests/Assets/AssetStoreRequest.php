<?php

namespace App\Http\Requests\Assets;

use App\Enums\AssetTypeEnum;
use App\Http\Requests\Helpers\ExceptionValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetStoreRequest extends FormRequest
{
    use ExceptionValidation;

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
}
