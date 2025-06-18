<?php

namespace Modules\PkgSanction\App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ExportService
{
    public function exportData(array $data, string $filename = 'export.xlsx')
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $rowNum = 1;
        foreach ($data as $row) {
            $colNum = 1;
            foreach ($row as $cellValue) {
                $cell = Coordinate::stringFromColumnIndex($colNum) . $rowNum;
                $sheet->setCellValue($cell, $cellValue);
                $colNum++;
            }
            $rowNum++;
        }

        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'export');
        $writer->save($tempFile);

        return ['path' => $tempFile, 'filename' => $filename];
    }
}
