<?php

namespace Modules\PkgSanction\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Modules\PkgSanction\App\Enum\SanctionType;

class SanctionRulesRequest extends FormRequest
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
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'absences_max' => 'required|integer|min:1',
            'seuil_de_notification' => 'required|integer|min:0',
            'duree_sanction' => 'nullable|integer|min:0',
            'est_actif' => 'required|boolean',
            'sanction_type' => ['required', new Enum(SanctionType::class)],
        ];
    }
}
