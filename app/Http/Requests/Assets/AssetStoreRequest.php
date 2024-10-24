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
            'purchaseDate' => ['required', 'date', 'after_or_equal:today'],
            'quantity' => ['required', 'integer', 'min:1'],
            'quote' => ['required', 'numeric', 'min:0.01',],
            'type' => ['required', Rule::enum(AssetTypeEnum::class)],
        ];
    }
}
