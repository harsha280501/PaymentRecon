<?php

namespace App\Repositories\Excel;


use App\Interface\Excel\SpreadSheet;
use Closure;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Excel implements SpreadSheet {




    public $spreadsheet = null;






    /**
     * Initial row
     * @var int
     */
    public $startFrom = 4;







    /**
     * Exporting filename
     * @var string
     */
    public $filename = 'export.xlsx';




    public function __construct() {
        // Create a new Spreadsheet object
        $this->spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    }





    /**
     * Assign the Start from
     * @param int $startFrom
     * @return void
     */
    public function setStartFrom(int $startFrom): void {
        $this->startFrom = $startFrom;
    }





    /**
     * Set file name
     * @param int $startFrom
     * @return void
     */
    public function setFilename(string $filename): void {
        $this->filename = $filename;
    }






    /**
     * Summary of generateAndDownload
     * @param array $data
     * @return bool|string
     */
    public function generateAndDownload(array $data, array $headers = []) {



        // Set some properties for the Excel file
        $this->spreadsheet->getProperties()
            ->setTitle('Workbook')
            ->setDescription('');






        // Add data to the Spreadsheet dynamically
        $row = $this->startFrom;

        if ($headers != null) {

            $col = 1;

            // $this->spreadsheet->getActiveSheet()->freezePane($this->getColumnLetter($col) . "$col:" . $this->getColumnLetter($col)); //($columnName . $row)->
            foreach ($headers as $value) {
                $columnName = $this->getColumnLetter($col);
                $this->spreadsheet->getActiveSheet()->setCellValue($columnName . $row, $value);

                // setAutoSize
                // add the styles in here
                $this->spreadsheet->getActiveSheet()->getCell($columnName . $row)->getStyle()->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '3682cd'], // Background color (blue)
                    ],
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'], // Border color (black)
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color (black)
                        ],
                    ],
                ]);

                $col++;
            }

            // Freeze the row after setting headers
            // $this->spreadsheet->getActiveSheet()->freezePane(1, $row);

            $row++;
        }


        foreach ($data as $item) {
            $col = 1;
            foreach ($item as $value) {
                $columnName = $this->getColumnLetter($col);
                $this->spreadsheet->getActiveSheet()->setCellValue($columnName . $row, $value);

                $this->spreadsheet->getActiveSheet()->getCell($columnName . $row)->getStyle()->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color (black)
                        ],
                    ],
                ]);


                $col++;
            }
            $row++;
        }


        $this->spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setAutoSize(true);

        // Save the Spreadsheet to a temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'excel_export');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($this->spreadsheet);
        $writer->save($tempFile);

        return $tempFile;
    }





    protected function getColumnLetter($columnIndex) {
        // Convert column index to letter
        $columnLetter = '';
        while ($columnIndex > 0) {
            $columnIndex--;
            $columnLetter = chr($columnIndex % 26 + 65) . $columnLetter;
            $columnIndex = (int) ($columnIndex / 26);
        }
        return $columnLetter;
    }

}