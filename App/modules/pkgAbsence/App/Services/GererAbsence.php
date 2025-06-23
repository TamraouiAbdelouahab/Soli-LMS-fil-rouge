<?php

namespace Modules\PkgAbsence\App\Services;

use Modules\PkgAbsence\App\Models\Absence;

class GererAbsence
{
    public function listAbsences()
    {
        return Absence::with(['apprenant', 'seance'])->latest()->get();
    }

    public function createAbsence($data)
    {
        return Absence::create($data);
    }

    public function bulkCreateAbsences(array $dataList)
    {
        // Création multiple d'absences via insert
        // Attention : insert ne gère pas les events Eloquent, si besoin tu peux faire un foreach create
        return Absence::insert($dataList);
    }

    public function updateAbsence($id, $data)
    {
        $absence = Absence::findOrFail($id);
        $absence->update($data);
        return $absence;
    }

    public function deleteAbsence($id)
    {
        return Absence::destroy($id);
    }

    public function getAbsence($id)
    {
        return Absence::with(['apprenant', 'seance'])->findOrFail($id);
    }
}
