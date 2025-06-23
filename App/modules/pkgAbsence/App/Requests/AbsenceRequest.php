<?php

namespace Modules\PkgAbsence\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AbsenceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'apprenant_id' => 'required|integer|exists:apprenants,id',
            'seance_id' => 'required|integer|exists:seances,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'justifie' => 'boolean',
            'est_sanctionnée' => 'boolean',
            'sanction_absence_id' => 'nullable|integer|exists:sanction_absences,id',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'apprenant_id.required' => 'L\'apprenant est requis.',
            'apprenant_id.exists' => 'L\'apprenant sélectionné n\'existe pas.',
            'seance_id.required' => 'La séance est requise.',
            'seance_id.exists' => 'La séance sélectionnée n\'existe pas.',
            'user_id.exists' => 'L\'utilisateur spécifié n\'existe pas.',
            'sanction_absence_id.exists' => 'La sanction sélectionnée n\'existe pas.',
            'notes.max' => 'Les notes ne peuvent pas dépasser 1000 caractères.',
        ];
    }

    protected function prepareForValidation()
    {
        // S'assurer que user_id est défini
        if (!$this->has('user_id') || !$this->user_id) {
            $this->merge([
                'user_id' => Auth::id()
            ]);
        }

        // Convertir les valeurs booléennes
        $this->merge([
            'justifie' => $this->boolean('justifie'),
            'est_sanctionnée' => $this->boolean('est_sanctionnée'),
        ]);
    }
}
