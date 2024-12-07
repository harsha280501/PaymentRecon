<?php


namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * Livewire Page with Tabs
 */
trait ReadsExcel {




    /**
     * Read Excel Files
     * @param string $path
     * @return array
     */
    public function reader(string $path) {
        $inputFileTypeIdentify = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileTypeIdentify);
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);

        $spreadsheet = $reader->load($path);
        return $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    }









    /**
     * Format the Excel Date
     * @param string|null $date
     * @return string
     */
    public function format(string|null $date) {

        if (!$date) {
            return null;
        }

        $_string = preg_replace('/[^\w]/', '-', $date);

        try {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($_string)->format('Y-m-d');
            } catch (\Throwable $th) {
                return Carbon::parse($_string)->format('Y-m-d');
            }
        } catch (\Throwable $th) {
            return Carbon::createFromFormat('m-d-Y', $_string)->format('Y-m-d');
        }
    }








    public function withHeaders(array $headers, array $data) {
        $combinedData = [];

        // Ensure both arrays have the same number of elements for proper mapping
        if (count($headers) !== count($data)) {
            throw new InvalidArgumentException('Heading and data arrays must have the same number of elements.');
        }

        // for ($i = 1; $i < count($headers); $i++) {
        
        foreach ($headers as $key => $value) {
            $combinedData[$value] = $data[$key];
        }

        return $combinedData;
    }



    /**
     * Convert numbers to integers
     *
     * @param string $char
     * @return integer
     */
    function alphaToNumber(string $char): int {
        $char = strtolower($char); // Ensure lowercase for consistent mapping
        $asciiValue = ord($char);

        if ($asciiValue >= 97 && $asciiValue <= 122) {
            // Lowercase letters (a-z)
            return $asciiValue - 96;
        } elseif ($asciiValue >= 65 && $asciiValue <= 90) {
            // Uppercase letters (A-Z)
            return $asciiValue - 64;
        } else {
            // Handle non-alphabetic characters (optional)
            throw new InvalidArgumentException("Input must be an English alphabet (a-z or A-Z)");
        }
    }


    /**
     * Convert the number to Alphabets
     *
     * @param integer $number
     * @param boolean $uppercase
     * @return string
     */
    function numberToAlpha(int $number, bool $uppercase = true): string {
        if ($number < 1 || $number > 26) {
            throw new InvalidArgumentException("Number must be between 1 and 26");
        }

        $baseValue = $uppercase ? 65 : 97; // Base ASCII value for A (uppercase) or a (lowercase)
        return chr($baseValue + $number - 1);
    }   

}