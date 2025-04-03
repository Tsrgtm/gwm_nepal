<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\AdsForm as AdsFormModel;

Class ExcelExport extends Controller{
    public function exportToExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Phone');
        $sheet->setCellValue('E1', 'Location');
        $sheet->setCellValue('F1', 'Message');
        $sheet->setCellValue('G1', 'Status');
        $sheet->setCellValue('H1', 'Created At');

        $adsFormsData = AdsFormModel::all()->toArray();
        $row = 2;
        foreach ($adsFormsData as $adsForm) {
            $sheet->setCellValue("A{$row}", $adsForm['id']);
            $sheet->setCellValue("B{$row}", $adsForm['name']);
            $sheet->setCellValue("C{$row}", $adsForm['email']);
            $sheet->setCellValue("D{$row}", $adsForm['phone']);
            $sheet->setCellValue("E{$row}", $adsForm['location']);
            $sheet->setCellValue("F{$row}", $adsForm['message'] ?? 'N/A');
            $sheet->setCellValue("G{$row}", $adsForm['status']);
            $sheet->setCellValue("H{$row}", $adsForm['created_at']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'ads_forms_' . now()->format('Y-m-d_H-i') . '.xlsx';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}