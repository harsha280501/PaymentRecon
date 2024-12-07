<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\MDateFormat;


class ParseDateService {


    public static function processDate(string $dateString) {
        // find a - in date
        if (str_contains($dateString, '-')) {
            return Carbon::parse($dateString)->format('Y-m-d');
        }
        // return main date
        return Carbon::createFromFormat('dmY', $dateString)->format("Y-m-d");
    }


    /**

     * Convert format for date
     * @param string $dateString
     * @return string
     */

    public static function convertFormatsForDate(string $dateString): string {

        // only parse if can be converted

        if (!strtotime($dateString)) {

            return $dateString;

        }

        $format_date = Carbon::parse(strtotime($dateString));

        return $format_date->format('Y-m-d');

    }


    /**
     * Summary of dateFormattedData
     * @param array $needles
     * @param array $heyStack
     * @return array
     */
    public static function dateFormattedData(array $needles, array $heyStack): array {
        // looping through and converting format
        $heyStack = collect($heyStack)->map(function ($item, $needle) use ($needles) {
            return in_array($needle, $needles) ? $this->format($item) : $item;
        })->toArray();
        // return main array with formated dates
        return $heyStack;
    }

    /**
     * Format the date
     * @param string $date
     * @return string
     */
    public static function format(string $date, $formattorString = 'Y-m-d'): string {
        $main = Carbon::parse($date);
        return $main->format($formattorString);
    }



    public static function convertDateFormatUsingDB(string $date, string $bankname) {
        $dateformatselect = MDateFormat::where('bankName', '=', $bankname)->first();

        $bankDateFormat = $dateformatselect->bankDateFormat;

        $datelength = strlen($date);

        $formatedd = '';

        if ($datelength == 0 || $datelength < 7) {

            return NULL;

        } else {

            if ($bankDateFormat == "MM/DD/YYYY" && $bankname == "ICICI Card") {
                if ($datelength > 10) {
                    $format_date = Carbon::parse(strtotime($date));
                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                }
                if ($datelength <= 10) {
                    $format_date = Carbon::parse($date);
                    $formatedd = $format_date->format('Y-m-d');
                }
            }

            if ($bankDateFormat == "DD-MM-YYYY" && $bankname == "ICICI Cash MIS") {
                if ($datelength > 10) {
                    $format_date = Carbon::parse(strtotime($date));
                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                }

                if ($datelength <= 10) {
                    if (str_contains($date, '/')) {
                        $formatedd = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                    }

                    if (str_contains($date, '-')) {

                        $formatedd = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
                    }

                }
            }

            if ($bankDateFormat == "DD-MMM-YY" && $bankname == "SBI Cash MIS") {
                if ($datelength > 10) {
                    $format_date = Carbon::parse(strtotime($date));
                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                }

                if ($datelength <= 10) {
                    $format_date = Carbon::parse($date);
                    $formatedd = $format_date->format('Y-m-d');

                }
            }

            if ($bankDateFormat == "DD-MM-YYYY" && $bankname == "SBI Card") {
                if ($datelength > 10) {
                    $format_date = Carbon::parse(strtotime($date));
                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                }

                if ($datelength <= 10) {
                    $format_date = Carbon::parse($date);
                    $formatedd = $format_date->format('Y-m-d');

                }
            }


            // HDFC 

            if ($bankDateFormat == "DD-MMM-YY" && $bankname == "HDFC Card") {

                if ($datelength > 10) {
                    $format_date = Carbon::parse($date);

                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                    return $format_date->format('Y-m-d H:i:s A');
                }

                if ($datelength <= 10) {
                    $format_date = Carbon::parse($date);

                    $formatedd = $format_date->format('Y-m-d');
                    return $format_date->format('Y-m-d');
                }
            }

            if ($bankDateFormat == "DD-MMM-YY" && $bankname == "HDFC UPI") {

                if ($datelength > 10) {
                    $format_date = Carbon::parse($date);

                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                    return $format_date->format('Y-m-d H:i:s A');
                }

                if ($datelength <= 10) {
                    //$format_date = Carbon::parse($date);

                    //$formatedd = $format_date->format('Y-m-d');
                    //return $format_date->format('Y-m-d');
                    //return Carbon::parse($date)->format('Y-m-d');

                    $format_date = Carbon::parse($date);
                    $formatedd = $format_date->format('Y-m-d');
                    return $format_date->format('Y-m-d');
                }
            }

            if ($bankDateFormat == "D-MM-YYYY" && $bankname == "HDFC Cash MIS") {

                if ($datelength == 7) {
                    $deptdt_date = substr($date, 0, 1);
                    $deptdt_month = substr($date, 1, 2);
                    $deptdt_year = substr($date, 3, 6);
                    $deptdt_formatted = $deptdt_year . '-' . $deptdt_month . '-' . $deptdt_date;
                    return str($deptdt_formatted);
                }

                $deptdt_date = substr($date, 0, 2);
                $deptdt_month = substr($date, 2, 2);
                $deptdt_year = substr($date, 4, 7);
                $deptdt_formatted = $deptdt_year . '-' . $deptdt_month . '-' . $deptdt_date;

                return str($deptdt_formatted);
            }

            // HDFC 

            // AXIS

            if ($bankDateFormat == "DD-MM-YYYY" && $bankname == "Axis Cash MIS") {

                if ($datelength > 10) {
                    $format_date = Carbon::parse(strtotime($date));
                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                }

                if ($datelength <= 10) {
                    $format_date = Carbon::parse($date);
                    $formatedd = $format_date->format('Y-m-d');

                }
            }

            // IDFC

            if ($bankDateFormat == "DD-MM-YYYY" && $bankname == "IDFC Cash MIS") {

                if ($datelength > 10) {
                    $format_date = Carbon::parse(strtotime($date));
                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                }

                if ($datelength <= 10) {
                    $format_date = Carbon::parse($date);
                    $formatedd = $format_date->format('Y-m-d');

                }
            }

            // AMEX Card

            if ($bankDateFormat == "DD/MM/YYYY" && $bankname == "Amex Card") {

                if ($datelength > 10) {
                    $format_date = Carbon::parse(strtotime($date));
                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                }

                if ($datelength <= 10) {
                    //dd($bankDateFormat.$datelength.":".$date);
                    $formatedd = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                    // $formatedd=$format_date->format('Y-m-d');

                }
            }

            // PayTM

            if ($bankDateFormat == "YYYY-MM-DD" && $bankname == "PayTM") {

                if ($datelength > 10) {
                    // $format_date = Carbon::parse(strtotime($date));
                    //$formatedd=$format_date->format('Y-m-d H:i:s A');
                    $formatedd = $date;
                }

                if ($datelength <= 10) {
                    $format_date = Carbon::parse($date);
                    $formatedd = $format_date->format('Y-m-d');

                }
            }

            // PayTM

            if ($bankDateFormat == "DD-MM-YYYY" && $bankname == "PhonePay") {

                if ($datelength > 10) {
                    $format_date = Carbon::parse(strtotime($date));
                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                }

                if ($datelength <= 10) {
                    $format_date = Carbon::parse($date);
                    $formatedd = $format_date->format('Y-m-d');

                }
            }


        } // ELSE ENDS      


        // 

        return $formatedd;

    }




    public static function formatDate($date) {
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
}