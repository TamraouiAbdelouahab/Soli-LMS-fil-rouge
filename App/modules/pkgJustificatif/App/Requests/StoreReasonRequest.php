<?php

namespace Modules\PkgJustificatif\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReasonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code'=>'required | max:10 |string | unique:raisons',
            'libelle'=>'required | max:255 |string | unique:raisons',
            'description'=>'nullable | string',
        ];
    }
    public function messages()
    {
        return [
            'code.required' => 'Le code est requis',
            'libelle.required' => 'Le libelle est requis',
        ];
    }
}
