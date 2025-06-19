<?php

namespace Modules\PkgJustificatif\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJustificationRequest extends FormRequest
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

            'dateFin' => 'required|date|after:dateDebut',

            'fichier' => 'required|file|mimes:png,jpg,jpeg,pdf',

            'description' => 'required|string',

            'status' => 'required|in:EN_ATTENTE,ACCEPTE,REJETE',

            'raison' => 'required|exists:raisons,id',

            'apprenant' => 'required|exists:apprenants,id',
        ];
    }
    public function messages()
    {
        return [
            'dateFin.after' => 'La date de fin doit être après la date de début',
            'fichier.mimes' => 'Le fichier doit être un fichier png, jpg, jpeg ou pdf',
            'status.in' => 'Le statut doit être en attente, accepte ou rjete',
            'dateDepot.required' => 'La date de dépôt est obligatoire',
            'dateDebut.required' => 'La date de début est obligatoire',
            'dateFin.required' => 'La date de fin est obligatoire',
            'description.required' => 'La description est obligatoire',
            'status.required' => 'Le statut est obligatoire',
            'raison_id.required' => 'La raison est obligatoire',
            'raison_id.exists' => 'La raison doit exister',
            'apprenant_id.required' => 'L\'apprenant est obligatoire',
            'apprenant_id.exists' => 'L\'apprenant doit exister',
        ];
    }
}
