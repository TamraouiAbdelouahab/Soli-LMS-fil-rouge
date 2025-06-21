<?php

namespace Modules\PkgJustificatif\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJustificationByApprenantRequest extends FormRequest
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
            'dateDepot' => 'required|date',

            'dateDebut' => 'required|date',

            'dateFin' => 'required|date|after_or_equal:dateDebut',

            'fichier' => 'required|file|mimes:png,jpg,jpeg,pdf',

            'description' => 'required|string',

            'raison' => 'required|exists:raisons,id',
        ];
    }
    public function messages()
    {
        return [
            'dateFin.after' => 'La date de fin doit être après la date de début',
            'fichier.mimes' => 'Le fichier doit être un fichier png, jpg, jpeg ou pdf',
            'dateDepot.required' => 'La date de dépôt est obligatoire',
            'dateDebut.required' => 'La date de début est obligatoire',
            'dateFin.required' => 'La date de fin est obligatoire',
            'fichier.required' => 'Le fichier est obligatoire',
            'description.required' => 'La description est obligatoire',
            'raison_id.required' => 'La raison est obligatoire',
            'raison_id.exists' => 'La raison doit exister',

        ];
    }
}
