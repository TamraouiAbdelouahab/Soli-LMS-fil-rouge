<?php

namespace Modules\PkgSanction\App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class ExportService
{
    public function exportData(array $data, string $filename = 'export.csv')
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

        $writer = new Csv($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'export');
        $writer->save($tempFile);

        return ['path' => $tempFile, 'filename' => $filename];
    }
}
