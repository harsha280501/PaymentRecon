<?php

namespace App\Services;

use App\Models\Config;
use App\Models\Menu;
use App\Models\MHDFCTID;
use App\Models\UserMenu;
use App\Models\Store;
use App\Traits\HandlesDates;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\MICICIMID;
use App\Models\MSBIMID;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use App\Models\MAmexMID;
use App\Models\MFLInwardCashAgencyMISSBIPos;
use App\Models\MFLInwardCashMIS2SBIPos;
use App\Models\User;

class ExcelUploadGeneralService
{

    use HandlesDates;

    public static function convertPriceFormatUsingNumeric(string $amount)
    {
        $amountlength = strlen(ltrim($amount, "0"));

        if ($amountlength == 0) {
            return "0.00";
        } else {
            return ltrim($amount, "0");
        }
    }



    public static function getSAPCodeUsingRetekCodeForICICICash(string $retekCode)
    {

        $sapCode = "";

        $sapselect = Store::select('Store ID')->where('RETEK Code', '=', $retekCode)->get();
        $sapCount = $sapselect->count();

        if ($sapCount > 0) {

            $sapCode = $sapselect->toArray()[0]['Store ID'];
        }

        return $sapCode;
    }

    public static function getReteckCodeUsingPkupForICICICash(string $pkup_pt_code)
    {
        $retekCode = "";

        $reteckselect = Store::select('RETEK Code')->where('RETEK Code', '=', $pkup_pt_code)->get();
        $reteckCount = $reteckselect->count();

        if ($reteckCount > 0) {

            $retekCode = $reteckselect->toArray()[0]['RETEK Code'];
        }

        return $retekCode;
    }


    public static function getSAPCodeUsingRetekCodeForSBICash(string $retakeCode)
    {

        $sapCode = "";

        $sapselect = Store::select('Store ID')->where('RETEK Code', '=', $retakeCode)->get();
        $sapCount = $sapselect->count();

        if ($sapCount > 0) {
            $sapCode = $sapselect->toArray()[0]['Store ID'];
        }

        return $sapCode;
    }

    public static function getReteckCodeUsingPkupForSBICash(string $pkup_pt_code)
    {

        $retekCode = "";

        $reteckselect = Store::select('RETEK Code')->where('RETEK Code', '=', $pkup_pt_code)->get();
        $reteckCount = $reteckselect->count();

        if ($reteckCount > 0) {
            $retekCode = $reteckselect->toArray()[0]['RETEK Code'];
        }

        return $retekCode;
    }


    public static function getStoreIDUsingRetekCodeForSBI(string|null $retekCode): string|null
    {

        $sapCode = "";

        $sapselect = Store::select('Store ID')->where('RETEK Code', '=', $retekCode)->get();
        $sapCount = $sapselect->count();

        if ($sapCount > 0) {
            $sapCode = $sapselect->toArray()[0]['Store ID'];
        }

        return $sapCode;
    }

    public static function getReteckCodeUsingTIDForSBI(string|null $mid, string|null $transactionDt): array
    {

        $main_ = [
            "retekCode" => null,
            "storeID" => null,
            "brand" => null
        ];


        $data_ = $mid && $transactionDt ? MSBIMID::select('storeID', 'brandName', 'newRetekCode', 'oldRetekCode', 'conversionDt')
            ->where('MID', '=', $mid)
            ->where('closureDate', '=', null)
            ->where('isActive', 1)
            ->first() : null;


        if ($data_) {
          
                $main_["retekCode"] = $data_->newRetekCode;
                $main_["storeID"] = $data_->storeID;
                $main_["brand"] = $data_->brandName;
            }

        return $main_;
    }


    public static function getReteckCodeUsingPkPtCodeHDFC(string $mid)
    {
        if (!$mid) {
            return null;
        }
        $sapselect = Store::where('RETEK Code', $mid)->pluck('RETEK Code');
        return isset($sapselect[0]) ? $sapselect[0] : null;
    }

    public static function getStoreIDUsingPkPtCodeHDFC(string|null $retakCode): string|null
    {

        if (!$retakCode) {
            return null;
        }

        $sapselect = Store::where('RETEK Code', $retakCode)->pluck('Store ID');

        return $sapselect[0] ? $sapselect[0] : null;
    }

    public static function getReteckCodeUsingTIDForHDFC(string|null $tid, string|null $transactionDt): array|null
    {

        $data = array();
        $data['retekCode'] = null;
        $data['storeID'] = null;
        $data['brandName'] = null;

        if (!$tid || !$transactionDt) {
            return $data;
        }

        $reteckselect = MHDFCTID::select('storeID', 'brandName', 'newRetekCode', 'oldRetekCode', 'conversionDt')->where('TID', '=', $tid)
            ->where('isActive', '=', 1)->where('closureDate', '=', null)->get();



        $reteckCount = $reteckselect->count();

        if ($reteckCount > 0) {
          
                $storedata = $reteckselect->toArray()[0];
                $data['retekCode'] = $storedata['newRetekCode'];
                $data['storeID'] = $storedata['storeID'];
                $data['brandName'] = $storedata['brandName'];
            
        }

        return $data;
    }



    public static function getStoreIDUsingRetekCodeForHDFC(string|null $retekCode): string|null
    {

        $sapCode = "";
        $sapselect = Store::select('Store ID')->where('RETEK Code', '=', $retekCode)->get();
        $sapCount = $sapselect->count();

        if ($sapCount > 0) {
            $sapCode = $sapselect->toArray()[0]['Store ID'];
        }

        return $sapCode;
    }



    // AXIS BANK
    public static function getSAPCodeUsingRetekCodeForAXISCash(string $retakeCode)
    {

        $sapCode = "";

        $sapselect = Store::select('Store ID')->where('RETEK Code', '=', $retakeCode)->get();
        $sapCount = $sapselect->count();

        if ($sapCount > 0) {

            $sapCode = $sapselect->toArray()[0]['Store ID'];
        }

        return $sapCode;
    }



    public static function getReteckCodeUsingPkupForAXISCash(string $pkup_pt_code)
    {
        $retekCode = "";

        $reteckselect = Store::select('RETEK Code')->where('RETEK Code', '=', $pkup_pt_code)->get();
        $reteckCount = $reteckselect->count();

        if ($reteckCount > 0) {

            $retekCode = $reteckselect->toArray()[0]['RETEK Code'];
        }

        return $retekCode;
    }




    // IDFC BANK
    public static function getSAPCodeUsingRetekCodeForIDFCCash(string $retakeCode)
    {

        $sapCode = "";

        $sapselect = Store::select('SAPcode')->where('Retak code', '=', $retakeCode)->get();
        $sapCount = $sapselect->count();

        if ($sapCount > 0) {

            $sapCode = $sapselect->toArray()[0]['SAPcode'];
        }

        return $sapCode;
    }



    public static function getReteckCodeUsingPkupForIDFCCash(string $pkup_pt_code)
    {
        $retekCode = "";

        $reteckselect = Store::select('Retak code')->where('Retak code', '=', $pkup_pt_code)->get();
        $reteckCount = $reteckselect->count();

        if ($reteckCount > 0) {

            $retekCode = $reteckselect->toArray()[0]['Retak code'];
        }

        return $retekCode;
    }



    //getSapCodeUsingMIDForAMEX
    public static function getStoreUDUsingRetekForAMEX(string|null $retekCode): string|null
    {

        $sapCode = "";

        $sapselect = Store::select('Store ID')->where('RETEK Code', '=', $retekCode)->get();
        $sapCount = $sapselect->count();

        if ($sapCount > 0) {

            $sapCode = $sapselect->toArray()[0]['Store ID'];
        }

        return $sapCode;
    }




    public static function getReteckCodeUsingTIDForAMEX(string|null $mid, string|null $transactionDt): array
    {

        $main_ = [
            "retekCode" => null,
            "storeID" => null,
            "brand" => null
        ];

        $data_ = $mid && $transactionDt ? MAmexMID::select('storeID', 'brandName', 'newRetekCode', 'oldRetekCode', 'conversionDt')
            ->where('MID', '=', $mid)
            ->where('closureDate', '=', null)
            ->where('isActive', 1)
            ->first() : null;

        if ($data_) {
         
                $main_["retekCode"] = $data_->newRetekCode;
                $main_["storeID"] = $data_->storeID;
                $main_["brand"] = $data_->brandName;
            
        }

        return $main_;
    }



    // PayTM 
    public static function getStoreUIDUsingRetekCodeForPayTM(string|null $retekCode): string|null
    {

        $sapCode = "";

        $sapselect = Store::select('Store ID')->where('RETEK Code', '=', $retekCode)->get();
        $sapCount = $sapselect->count();

        if ($sapCount > 0) {

            $sapCode = $sapselect->toArray()[0]['Store ID'];
        }

        return $sapCode;
    }



    public static function getReteckCodeUsingPkupForPayTM(string $pkup_pt_code)
    {
        $retekCode = "";

        $reteckselect = Store::select('Retak code')->where('Retak code', '=', $pkup_pt_code)->get();
        $reteckCount = $reteckselect->count();

        if ($reteckCount > 0) {
            $retekCode = $reteckselect->toArray()[0]['Retak code'];
        }

        return $retekCode;
    }



    // PHONEPAY
    public static function getStoreIDUsingRetekCodeForPhonePay(string|null $retekCode): string|null
    {

        $sapCode = "";

        $sapselect = Store::select('Store ID')->where('RETEK Code', '=', $retekCode)->get();
        $sapCount = $sapselect->count();

        if ($sapCount > 0) {

            $sapCode = $sapselect->toArray()[0]['Store ID'];
        }

        return $sapCode;
    }




    public static function getReteckCodeUsingPkupForPhonePay(string $store_id)
    {
        $retake_code = "";

        $reteckselect = Store::select('Retak code')->where('Retak code', '=', $store_id)->get();
        $reteckCount = $reteckselect->count();

        if ($reteckCount > 0) {

            $retake_code = $reteckselect->toArray()[0]['Retak code'];
        }

        return $retake_code;
    }






    /**
     * Retek Code
     * @param string $store
     * @return array
     */
    public static function getRetekCodeFromDepositSlipNo(string|null $depositSlip, string|null $pickUpCode) {

        $_storeIDUsingDepositSlipNumber = self::getReteckStoreIDForAllCashUpload($depositSlip);
        $_storeIDUsingPkupPtCode = self::getReteckStoreIDForAllCashUpload($pickUpCode);

        if(!$_storeIDUsingDepositSlipNumber['RETEK Code']) {
            return $_storeIDUsingPkupPtCode;
        }

        return $_storeIDUsingDepositSlipNumber;
    }






    public static function getReteckStoreIDForAllCashUpload($store_id)
    {


        if (!is_numeric($store_id)) {
            $store_id = 0;
        }

        $storelength = strlen($store_id);

        $data = array();
        $data['RETEK Code'] = "";
        $data['Store ID'] = "";
        $data['Brand Desc'] = "";

        if ($storelength <= 4) {
            $reteckselect = Store::select('RETEK Code', 'Store ID', 'Brand Desc')->where('Store ID', '=', $store_id)->get();
        }

        if ($storelength > 4) {
            $reteckselect = Store::select('RETEK Code', 'Store ID', 'Brand Desc')->where('RETEK Code', '=', $store_id)->get();
        }

        $reteckCount = $reteckselect->count();

        if ($reteckCount > 0) {

            $storedata = $reteckselect->toArray()[0];
            $data['RETEK Code'] = $storedata['RETEK Code'];
            $data['Store ID'] = $storedata['Store ID'];
            $data['Brand Desc'] = $storedata['Brand Desc'];
        }

        return $data;
    }

    public static function getStoreIDFromVAN($vanNumber)
    { // van number after stripping

        $strippedVan = substr(str_replace('i', '1', $vanNumber), -4);


        if (!is_numeric($strippedVan)) {
            return [
                "Store ID" => null,
                "RETEK Code" => null,
                "Brand Desc" => null
            ];
        }

        $res = MFLInwardCashAgencyMISSBIPos::where('storeID', $strippedVan)
            ?->first();

        return [
            "Store ID" => $res?->storeID,
            "RETEK Code" => $res?->retekCode,
            "Brand Desc" => $res?->brand,
        ];
    }

    public static function getStoreIDWalletfrommstore($get_retekCode)
    { // van number after strippin

        
        $res = Store::where('RETEK Code', $get_retekCode)
            ?->first();

        return [
            "Store ID" => $res?->storeID,
            "RETEK Code" => $res?->retekCode,
            "Brand Desc" => $res?->brand,
        ];
    }






    public static function getSBIHCMStoreID(string $retekCode): object {

        $res = Store::where('RETEK Code', $retekCode)
        ?->first();
        
        return (object) [
            "storeID" => $res?->{'Store ID'},
            "retekCode" => $res?->{'RETEK Code'},
            "brand" => $res?->{'Brand Desc'},
        ];
    }
}
