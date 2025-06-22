<?php

namespace Modules\PkgAbsence\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Autoriser toutes les requêtes (ajuste selon ta logique d'authentification)
        return true;
    }

    public function rules(): array
    {
        return [
            'apprenant_id' => 'required|exists:apprenants,id',
            'user_id' => 'required|exists:users,id',
            'seance_id' => 'required|exists:seances,id',
            'justifie' => 'required|boolean',
            'est_sanctionnée' => 'required|boolean',
            'sanction_absence_id' => 'nullable|exists:sanction_absences,id',
            'sanction_absence_calculee_id' => 'nullable|exists:sanction_absences_calculees,id',
        ];
    }

    public function messages(): array
    {
        return [
            'apprenant_id.required' => 'L\'apprenant est requis.',
            'user_id.required' => 'Le surveillant est requis.',
            'seance_id.required' => 'La séance est requise.',
            'justifie.required' => 'Le champ justification est requis.',
            'est_sanctionnée.required' => 'Le champ sanction est requis.',
            'sanction_absence_id.exists' => 'Sanction réelle invalide.',
            'sanction_absence_calculee_id.exists' => 'Sanction prévisionnelle invalide.',
        ];
    }
}
