<?php

namespace Modules\PkgJustificatif\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReasonRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'code' => 'required|string|max:10|unique:raisons,code,' . $id,
            'libelle' => 'required|string|max:255|unique:raisons,libelle,' . $id,
            'description' => 'nullable|string',
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
