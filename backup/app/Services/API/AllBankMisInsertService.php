<?php
declare(strict_types=1);
namespace App\Services\API;

//Models
use App\Models\MVehicle;
use App\Models\MFL_Inward_AllBankCashMIS;

//Others
use Illuminate\Database\Eloquent\Collection;
use DB;
use Carbon\Carbon;

class AllBankMisInsertService
{



    public static function AllBankMisInsert($request)
    {

        //return $request;
        $bankType = $request['bankType'];
        $from = $request['from'];
        $to  = $request['to'];

        $result = collect(\DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_ALLBANKMIS_CASH :bankType,:from,:to', [
            'bankType'           => $bankType,
            'from'           => $from,
            'to'           => $to,
        ]));

        if ($result) {

            $data['code'] = 0;
            $data['message'] = 'successfully!';
            $data['errorMessage'] = '';
            $data['bankType'] = $result;
            $data['error'] = false;
            return (!empty($data)) ? $data : null;
        } else {
            $data['code'] = null;
            $data['message'] = "";
            $data['bankType'] = 'Not successfully!';
            $data['error'] = true;
            return (!empty($data)) ? $data : null;
        }
    }

    public static function AllBankMisInsertCard($request)
    {

        //return $request;
        $bankType = $request['bankType'];
        $from = $request['from'];
        $to  = $request['to'];

        $result = collect(\DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_ALLBANKMIS_CARD :bankType,:from,:to', [
            'bankType'           => $bankType,
            'from'           => $from,
            'to'           => $to,
        ]));

        if ($result) {

            $data['code'] = 0;
            $data['message'] = 'successfully!';
            $data['errorMessage'] = '';
            $data['bankType'] = $result;
            $data['error'] = false;
            return (!empty($data)) ? $data : null;
        } else {
            $data['code'] = null;
            $data['message'] = "";
            $data['bankType'] = 'Not successfully!';
            $data['error'] = true;
            return (!empty($data)) ? $data : null;
        }
    }



    public static function AllWalletMisInsert($request)
    {

        //return $request;
        $bankType = $request['bankType'];
        $from = $request['from'];
        $to  = $request['to'];

        $result = collect(\DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_AllWalletMIS :bankType,:from,:to', [
            'bankType'           => $bankType,
            'from'           => $from,
            'to'           => $to
        ]));

        if ($result) {

            $data['code'] = 0;
            $data['message'] = 'successfully!';
            $data['errorMessage'] = '';
            $data['bankType'] = $result;
            $data['error'] = false;
            return (!empty($data)) ? $data : null;
        } else {
            $data['code'] = null;
            $data['message'] = "";
            $data['bankType'] = 'Not successfully!';
            $data['error'] = true;
            return (!empty($data)) ? $data : null;
        }
    }
}
