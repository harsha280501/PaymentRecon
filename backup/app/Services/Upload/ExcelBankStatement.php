<?php

namespace App\Services\Upload;

use App\Models\Config;
use App\Models\Menu;
use App\Models\UserMenu;
use App\Models\Store;
use App\Models\MDateFormat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\MICICIMID;
use App\Models\MSBIMID;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use App\Models\MAmexMID;


class ExcelBankStatement {

    public static function convertPriceFormatNumeric(string $amount) {
        $amountlength = strlen(ltrim($amount, "0"));

        if ($amountlength == 0) {
            return "0.00";
        } else {
            return ltrim($amount, "0");
        }
    }



    public static function convertDateForForBankSt(string $date, string $bankname) {
        $dateformatselect = MDateFormat::where('bankName', '=', $bankname)->first();

        $bankDateFormat = $dateformatselect->bankDateFormat;

        $datelength = strlen($date);

        $formatedd = '';

        if ($datelength == 0 || $datelength < 8) {
            return NULL;
        } else {
            // HDFC

            if ($bankDateFormat == "DD-MM-YYYY" && $bankname == "HDFC Bank Statement") {

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

            // ICICI

            if ($bankDateFormat == "DD-MM-YYYY" && $bankname == "ICICI Bank Statement") {

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

            if ($bankDateFormat == "DD-MM-YYYY" && $bankname == "IDFC Bank Statement") {

                if ($datelength > 10) {
                    $format_date = Carbon::parse(strtotime($date));
                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                }
                if ($datelength <= 10) {
                    $format_date = Carbon::parse($date);
                    $formatedd = $format_date->format('Y-m-d');
                }
            }


            // SBI

            if ($bankDateFormat == "DD-MM-YYYY" && $bankname == "SBI Bank Statement") {

                if ($datelength > 10) {
                    $format_date = Carbon::parse(strtotime($date));
                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                }
                if ($datelength <= 10) {
                    $format_date = Carbon::parse($date);
                    $formatedd = $format_date->format('Y-m-d');
                }
            }

            // Axis

            if ($bankDateFormat == "DD-MM-YYYY" && $bankname == "Axis Bank Statement") {

                if ($datelength > 10) {
                    $format_date = Carbon::parse(strtotime($date));
                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                }
                if ($datelength <= 10) {
                    $format_date = Carbon::parse($date);
                    $formatedd = $format_date->format('Y-m-d');
                }
            }

            // SBI Agency

            if ($bankDateFormat == "DD-MM-YYYY" && $bankname == "SBI Agency Cash") {


                try {
                    $format_date = Carbon::createFromFormat('dmY', $date);
                    $formatedd = $format_date->format('Y-m-d H:i:s A');
                } catch (\Throwable $th) {
                    if ($datelength > 10) {
                        $format_date = Carbon::parse(strtotime($date));
                        $formatedd = $format_date->format('Y-m-d H:i:s A');
                    }
                    if ($datelength <= 10) {
                        $format_date = Carbon::parse($date);
                        $formatedd = $format_date->format('Y-m-d');
                    }
                }
            }


        }
        return $formatedd;
    }
}
