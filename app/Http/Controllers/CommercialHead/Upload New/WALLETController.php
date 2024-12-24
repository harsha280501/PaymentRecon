<?php

namespace App\Http\Controllers\CommercialHead\Upload;

use App\Http\Controllers\Controller;

// Request

use App\Interface\MisReadLogsInterface;
use App\Models\BrandNotConsider;
use Illuminate\Http\Request;

use App\Models\MFLInwardWalletMISPayTMPos;
use App\Models\MFLInwardWalletMISPhonePayPos;
use App\Models\Store;
// Exception

use Exception;

// Services

use App\Services\GeneralService;
use App\Services\ParseDateService;
use App\Services\ExcelUploadGeneralService;
use App\Traits\GenerateTotalHTML;
// Others

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WALLETController extends Controller {

    use GenerateTotalHTML;

    public function __construct(
        public MisReadLogsInterface $repository
    ) {
    }


    public function PhonePayData(Request $request) {


        // Validating the given file extension
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:17048'
        ]);

        // Retrieve the uploaded file
        $file = $request->file('file');

        // Move the uploaded filee to a temporary location
        $destinationPath = storage_path('app/public/commercial/phonepaydata');
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/phonepaydata/') . $file_1_name;



        // checking if the filename is in the db
        if (MFLInwardWalletMISPhonePayPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
            return response()->json(['message' => 'The Filename already exists on the Database'], 409);
        }



        $inputFileTypeIdentify = \PhpOffice\PhpSpreadsheet\IOFactory::identify($targetPath);
        $inputFileTypeFormat = ucwords($inputFileTypeIdentify);

        if ($inputFileTypeFormat == 'csv' || $inputFileTypeFormat == 'CSV' || $inputFileTypeFormat == 'Csv') {
            $inputFileType = 'Csv';
        } else if ($inputFileTypeFormat == 'xls' || $inputFileTypeFormat == 'XLS' || $inputFileTypeFormat == 'Xls') {
            $inputFileType = 'Xls';
        } else if ($inputFileTypeFormat == 'xlsx' || $inputFileTypeFormat == 'XLSX' || $inputFileTypeFormat == 'Xlsx') {
            $inputFileType = 'Xlsx';
        }

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);
        //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
        $spreadsheet = $reader->load($targetPath);

        $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $arrayCount = count($worksheet);

        $error_msgs_arr = array();



        // setting the inserted count to zero
        $this->repository->startFrom(2);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $file_1_name,
            "table" => "MFL_Inward_WalletMIS_Phonepay",
            "bank" => "PhonePay",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {
            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $get_retekCode = trim($worksheet[$i]["E"]); // StoreId 
                $resultReteck = substr($get_retekCode, 0, 2);

                $storedata = null;

                $mer_ref_id = trim(str_replace("'", '', $worksheet[$i]["C"])); // MerchantReferenceId
                // $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload(substr($mer_ref_id, 0, 5));
                // dd( $mer_ref_id);

                if ($resultReteck == "S0") {
                    $trim_retekcode = substr($get_retekCode, 2);
                    $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($trim_retekcode);
                } else {
                    $pkup_pt_code = is_numeric($get_retekCode) ? $get_retekCode : 0; // if not numeric set it as zero
                    $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($pkup_pt_code);
                }

                $getstore_name = trim(str_replace("'", '', $worksheet[$i]["F"])); // StoreName
                // $storedataCount = count($storedata); // ! store Data is not going to be null ["storeID" => "", ...] -- never used


                if ($storedata['Store ID'] && $storedata['RETEK Code'] && $storedata['Brand Desc']) {
                    $retekCode = $storedata['RETEK Code'];
                    $storeID = $storedata['Store ID'];
                    $brand = $storedata['Brand Desc'];
                } else {

                    $resultStoreCheck = substr($getstore_name, 0, 2);
                    if ($resultStoreCheck == "S0") {
                        $trim_storecode = substr($getstore_name, 2);
                        $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($trim_storecode);
                    } else {

                        $pkup_storecode = is_numeric($getstore_name) ? $getstore_name : 0; // if not numeric set it as zero
                        $trim_storecode = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($pkup_storecode);

                        if ($trim_storecode['Store ID'] && $trim_storecode['RETEK Code'] && $trim_storecode['Brand Desc']) {
                            $trim_storecode = ExcelUploadGeneralService::getStoreIDWalletfrommstore($get_retekCode);
                        } else {
                            $_main = substr($mer_ref_id, 0, 5); # c
                            $trim_storecode = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($_main);
                        }


                    }

                    $retekCode = $trim_storecode['RETEK Code'];
                    $storeID = $trim_storecode['Store ID'];
                    $brand = $trim_storecode['Brand Desc'];
                }





                $col_bank = config('constants.WALLET.phonepayBankName'); // PHONEPAY
                $mer_code = trim(str_replace("'", '', $worksheet[$i]["A"])); // MerchantId
                $tid = trim(str_replace("'", '', $worksheet[$i]["G"])); // TerminalId       

                $deposit_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["L"])), 'PhonePay');
                $cr_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["M"])), 'PhonePay');

                $deposit_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["O"]))); // Amount
                $msf_comm = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["P"]))); // Fee
                $cgst_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["R"]))); // CGST
                $sgst_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["S"]))); // SGST
                $igst_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["Q"]))); // IGST
                $terminal_name = trim(str_replace("'", '', $worksheet[$i]["H"])); // TerminalName
                $store_name = trim(str_replace("'", '', $worksheet[$i]["F"])); // StoreName
                $instrument = trim(str_replace("'", '', $worksheet[$i]["J"])); // Instrument                
                $creation_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["K"])), 'PhonePay'); // CreationDate
                $pay_type = trim(str_replace("'", '', $worksheet[$i]["B"])); // PaymentType

                $phonepay_ref_id = trim(str_replace("'", '', $worksheet[$i]["D"])); // PhonePeReferenceId
                $service_provider = trim(str_replace("'", '', $worksheet[$i]["I"])); // From
                $bank_ref = trim(str_replace("'", '', $worksheet[$i]["N"])); // BankReferenceNo

                $userId = Auth::id();

                // assigning missing status from config constants file
                $missingStatus = config('constants.missingStatus.StoreID');

                // getting the Not considered brands
                $NotconsiderArrayBrand = BrandNotConsider::select('brand')->where('isActive', '=', 1)->pluck('brand')->toArray();


                // if everything is correct
                if ($storeID != "" && $retekCode != "") {
                    $missingStatus = 'Valid';
                }

                // if the brand is in Not considered brands
                if (in_array($brand, $NotconsiderArrayBrand)) {
                    $missingStatus = 'NotValid';
                }

                $totalGST = $cgst_amt + $sgst_amt + $igst_amt;
                // netamount = deposit - (-msfcomm - gst)
                $netAmount = $deposit_amount - (-($msf_comm) - $totalGST);

                $data = array(
                    'storeID' => $storeID,
                    'excelStoreID' => $get_retekCode,
                    'retekCode' => $retekCode,
                    'colBank' => $col_bank,
                    "brand" => $brand,
                    "merCode" => $mer_code,
                    "tid" => $tid,
                    "depositDt" => $deposit_dt,
                    "crDt" => $cr_dt,
                    "depositAmount" => $deposit_amount,
                    "msfComm" => $msf_comm,
                    "cgstAmt" => $cgst_amt,
                    "sgstAmt" => $sgst_amt,
                    "igstAmt" => $igst_amt,
                    'totalGst' => $totalGST,
                    'netAmt' => $netAmount,
                    "terminalName" => $terminal_name,
                    "storeName" => $store_name,
                    "instrument" => $instrument,
                    "creationDt" => $creation_dt,
                    "payType" => $pay_type,
                    "merRefId" => $mer_ref_id,
                    "phonepayRefId" => $phonepay_ref_id,
                    "serviceProvider" => $service_provider,
                    "bankRef" => $bank_ref,
                    "filename" => $file_1_name,
                    "missingRemarks" => $missingStatus,
                    "createdBy" => auth()->user()->userUID,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                );




                if ($mer_code != '' && $pay_type != '') {
                    if (MFLInwardWalletMISPhonePayPos::Insert($data)) {
                        $this->repository->increamentInsertedCount();
                    }
                }
            }

            // finializing the logs
            $this->repository->finializeLog();

            return response()->json([
                'message' => 'Success',
                "data" => $this->generateHTML(function () use ($getorinilfilename) {
                    return MFLInwardWalletMISPhonePayPos::select(
                        'depositAmount',
                        'missingRemarks',
                        DB::raw('ISNULL(depositDt, NULL) as depositDt'),
                        DB::raw('ISNULL(crDt, NULL) as crDt')
                    )->where('filename', 'like', '%' . $getorinilfilename . '%')->get();
                })
            ], 200);

        } catch (\Throwable $exception) {
            $this->repository->failedLog($exception);
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }



    //importPayTMData

    public function importPayTMData(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:17048'
        ]);


        $file = $request->file('file');
        $destinationPath = storage_path('app/public/commercial/PAYTMC');
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/PAYTMC/') . $file_1_name;


        // checking if the filename is in the db
        if (MFLInwardWalletMISPayTMPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
            return response()->json(['message' => 'The Filename already exists on the Database'], 409);
        }



        $inputFileTypeIdentify = \PhpOffice\PhpSpreadsheet\IOFactory::identify($targetPath);
        $inputFileTypeFormat = ucwords($inputFileTypeIdentify);

        if ($inputFileTypeFormat == 'csv' || $inputFileTypeFormat == 'CSV' || $inputFileTypeFormat == 'Csv') {
            $inputFileType = 'Csv';
        } else if ($inputFileTypeFormat == 'xls' || $inputFileTypeFormat == 'XLS' || $inputFileTypeFormat == 'Xls') {
            $inputFileType = 'Xls';
        } else if ($inputFileTypeFormat == 'xlsx' || $inputFileTypeFormat == 'XLSX' || $inputFileTypeFormat == 'Xlsx') {
            $inputFileType = 'Xlsx';
        }


        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);
        $spreadsheet = $reader->load($targetPath);

        $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

        $error_msgs_arr = array();

        // setting the inserted count to zero
        $this->repository->startFrom(2);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $file_1_name,
            "table" => "MFL_Inward_WalletMIS_PayTM",
            "bank" => "PayTM",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();


        try {
            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {
                $colBank = config('constants.WALLET.paytmBankName'); // bankName
                $orderID = trim(str_replace("'", '', $worksheet[$i]["B"])); //Order_ID
                $orderID_spilit = explode("-", trim($orderID));

                $retekCode = 0;

                if (count($orderID_spilit) > 1) {
                    $retekCode = $orderID_spilit[0]; // Store ID
                }

                $tid = trim(str_replace("'", '', $worksheet[$i]["AA"])); //POS_ID
                $mid = trim(str_replace("'", '', $worksheet[$i]["I"])); //MID                    

                $storeID = ExcelUploadGeneralService::getStoreUIDUsingRetekCodeForPayTM($retekCode);
                $brand = Store::where('Store ID', $storeID)?->first()?->{'Brand Desc'};

                $depositDt_replace = trim(str_replace("'", '', $worksheet[$i]["E"])); //Link_Description
                $crdt_replace = trim(str_replace("'", '', $worksheet[$i]["W"])); //Link_Description

                $depositDt = ParseDateService::convertDateFormatUsingDB($depositDt_replace, 'PayTM'); // Transaction_Date
                $cr_dt = ParseDateService::convertDateFormatUsingDB($crdt_replace, 'PayTM'); // Transaction_Date

                $depositAmount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["O"]))); //Amount
                $msf_comm = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["P"]))); //Commission

                $terminal_name = trim(str_replace("'", '', $worksheet[$i]["AN"])); //Link_Description
                $bank_ref = trim(str_replace("'", '', $worksheet[$i]["AS"])); //Bank_Transaction_ID 

                $store_name = trim(str_replace("'", '', $worksheet[$i]["J"])); //Merchant_Name                    
                $utr_no = trim(str_replace("'", '', $worksheet[$i]["U"])); //UTR_No. 

                $payout_date_replace = trim(str_replace("'", '', $worksheet[$i]["V"])); //Link_Description
                $payout_date = ParseDateService::convertDateFormatUsingDB($payout_date_replace, 'PayTM'); // Payout_Date

                $external_serial_no = trim(str_replace("'", '', $worksheet[$i]["AC"])); //External_Serial_No 
                $transaction_id = trim(str_replace("'", '', $worksheet[$i]["A"])); //Transaction_ID
                $instrument = trim(str_replace("'", '', $worksheet[$i]["X"])); //Payment_Mode
                $creation_dt_replace = trim(str_replace("'", '', $worksheet[$i]["F"])); //Link_Description
                $creation_dt = ParseDateService::convertDateFormatUsingDB($creation_dt_replace, 'PayTM'); // Updated_Date

                $pay_type = trim(str_replace("'", '', $worksheet[$i]["G"])); // Transaction_Type
                $payer_vpa = trim(str_replace("'", '', $worksheet[$i]["AZ"])); // Customer_VPA
                $payout_id = trim(str_replace("'", '', $worksheet[$i]["S"])); // Payout_ID
                $channel = trim(str_replace("'", '', $worksheet[$i]["T"])); //Channel
                $product_code = trim(str_replace("'", '', $worksheet[$i]["AE"])); //Product_Code
                $request_type = trim(str_replace("'", '', $worksheet[$i]["AH"])); //Request_Type
                $status = trim(str_replace("'", '', $worksheet[$i]["H"])); //Status

                $settled_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["AV"]))); //Settled_Amount                   

                $pcf = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["AW"])); //PCF
                $pcf_gst = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["AX"])); //PCF_GST
                $response_code = trim(str_replace("'", '', $worksheet[$i]["AY"])); //Response_code
                $response_message = trim(str_replace("'", '', $worksheet[$i]["BE"])); //Response_message
                $original_txn_value = trim(str_replace("'", '', $worksheet[$i]["BH"])); //Original_txn_value_before_promo
                $prepaid_card = trim(str_replace("'", '', $worksheet[$i]["BN"])); //Prepaid_Card
                $additionalcomments = trim(str_replace("'", '', $worksheet[$i]["BO"])); // AdditionalComments                
                $charge_target = trim(str_replace("'", '', $worksheet[$i]["BP"])); // Charge_Target
                $fee_factor = trim(str_replace("'", '', $worksheet[$i]["BQ"])); // Fee_Factor
                $bankgateway = trim(str_replace("'", '', $worksheet[$i]["BR"])); // Bank/Gateway


                $card_scheme = trim(str_replace("'", '', $worksheet[$i]["BS"])); // Card_Scheme
                $mer_ref_id = trim(str_replace("'", '', $worksheet[$i]["AB"])); // Merchant_Ref_ID
                $merchant_trackid = trim(str_replace("'", '', $worksheet[$i]["R"])); // Merchant_Order_ID
                $arn_no = trim(str_replace("'", '', $worksheet[$i]["CV"])); // ARN
                //$commission_rate  = trim($worksheet[$i]["AD"]); // Commission_Rate

                $commission_rate = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["AD"]))); //Settled_Amount
                $acquiring_service_fee = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["BT"]))); //ACQUIRING_SERVICE_FEE

                $acquiring_service_tax = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["BU"]))); //ACQUIRING_SERVICE_TAX

                $platform_service_fee = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["BV"]))); //PLATFORM_SERVICE_FEE

                $platform_service_tax = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["BW"]))); //PLATFORM_SERVICE_TAX                    

                $user_expected_credit_date = trim(str_replace("'", '', $worksheet[$i]["CE"])); //User_Expected_Credit_Date
                $settle_type = trim(str_replace("'", '', $worksheet[$i]["CX"])); //Settle_Type
                $merchant_payment_detail_1 = trim(str_replace("'", '', $worksheet[$i]["CY"])); //Merchant_Payment_Detail_1
                $customer_id = trim(str_replace("'", '', $worksheet[$i]["K"])); //Customer_ID


                $customer_nickname = trim(str_replace("'", '', $worksheet[$i]["L"])); //Customer_Nickname
                $payment_mobile_number = trim(str_replace("'", '', $worksheet[$i]["M"])); //Payment_Mobile_Number
                $payment_email_id = trim(str_replace("'", '', $worksheet[$i]["N"])); //Payment_Email_Id
                $issuing_bank = trim(str_replace("'", '', $worksheet[$i]["Y"])); // Issuing_Bank                
                $reference_transaction_id = trim(str_replace("'", '', $worksheet[$i]["Z"])); // Reference_Transaction_ID
                $gmv_tier = trim(str_replace("'", '', $worksheet[$i]["AF"])); // GMV_Tier
                $transaction_slab = trim(str_replace("'", '', $worksheet[$i]["AG"])); // Transaction_Slab
                $refund_type = trim(str_replace("'", '', $worksheet[$i]["AI"])); // Refund_Type
                $refund_actor = trim(str_replace("'", '', $worksheet[$i]["AJ"])); // Refund_Actor
                $split_flag = trim(str_replace("'", '', $worksheet[$i]["AK"])); // Split_Flag
                $split_mid = trim(str_replace("'", '', $worksheet[$i]["AL"])); // Split_MID
                $split_id = trim(str_replace("'", '', $worksheet[$i]["AM"])); // Split_Id
                $payment_reference_number = trim(str_replace("'", '', $worksheet[$i]["AO"])); //Payment_Reference_Number
                $is_prn_validated = trim(str_replace("'", '', $worksheet[$i]["AP"])); //Is_PRN_Validated
                $prn_validate_time = trim(str_replace("'", '', $worksheet[$i]["AQ"])); //PRN_Validate_Time
                $creditdebit_card_last_4_digits = trim(str_replace("'", '', $worksheet[$i]["AR"])); //Credit/Debit_Card_Last_4_Digits
                $promo_code = trim(str_replace("'", '', $worksheet[$i]["AT"])); //Promo_Code
                $promo_response = trim(str_replace("'", '', $worksheet[$i]["AU"])); //Promo_Response
                $card_bin = trim(str_replace("'", '', $worksheet[$i]["BA"])); //Card_BIN
                $customer_details = trim(str_replace("'", '', $worksheet[$i]["BB"])); //Customer_Details
                $link_name = trim(str_replace("'", '', $worksheet[$i]["BC"])); // Link_Name                
                $link_notes = trim(str_replace("'", '', $worksheet[$i]["BD"])); // Link_Notes
                $promo_discount_type = trim(str_replace("'", '', $worksheet[$i]["BF"])); // Promo_discount_type

                $promo_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["BG"]))); //Promo_Amount
                $total_bill_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["BI"]))); //Total_Bill_Amount
                $instant_discount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["BJ"]))); //Instant_Discount
                $mlv_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["BK"]))); //Instant_Discount
                $promo_cart_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["BX"]))); //Promo_Cart_Amount

                $auth_code = trim(str_replace("'", '', $worksheet[$i]["BL"])); // Auth_Code
                $rrn = trim(str_replace("'", '', $worksheet[$i]["BM"])); // RRN                    
                $reseller_id = trim(str_replace("'", '', $worksheet[$i]["BY"])); //Reseller_ID
                $reseller_name = trim(str_replace("'", '', $worksheet[$i]["BZ"])); //Reseller_Name
                $employee_id = trim(str_replace("'", '', $worksheet[$i]["CA"])); //Employee_Id
                $employee_name = trim(str_replace("'", '', $worksheet[$i]["CB"])); //Employee_Name
                $employee_phoneno = trim(str_replace("'", '', $worksheet[$i]["CC"])); //Employee_PhoneNo
                $employee_email = trim(str_replace("'", '', $worksheet[$i]["CD"])); //Employee_Email
                $order_reason = trim(str_replace("'", '', $worksheet[$i]["CF"])); //Order_Reason
                $customer_account_number = trim(str_replace("'", '', $worksheet[$i]["CG"])); // Customer_Account_Number                
                $customer_bank_ifsc = trim(str_replace("'", '', $worksheet[$i]["CH"])); // Customer_BANK_IFSC
                $template_id = trim(str_replace("'", '', $worksheet[$i]["CI"])); // TEMPLATE_ID
                $template_name = trim(str_replace("'", '', $worksheet[$i]["CJ"])); // TEMPLATE_NAME
                $foreign_currency = trim(str_replace("'", '', $worksheet[$i]["CK"])); // Foreign_Currency
                $foreign_currency_name = trim(str_replace("'", '', $worksheet[$i]["CL"])); // Foreign_Currency_Name
                $totalGST = trim(str_replace("'", '', $worksheet[$i]["Q"])); // Foreign_Currency_Name

                $foreign_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["CM"]))); //Foreign_Amount
                $exchange_rate = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["CN"]))); //Exchange_Rate
                $user_markup_rate = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["CO"]))); //Exchange_Rate                

                $refund_source = trim(str_replace("'", '', $worksheet[$i]["CP"])); //Refund_Source
                $sub_order_status = trim(str_replace("'", '', $worksheet[$i]["CQ"])); //Sub_Order_Status
                $refund_reversal_id = trim(str_replace("'", '', $worksheet[$i]["CR"])); //Refund_Reversal_Id
                $refund_reversal_status = trim(str_replace("'", '', $worksheet[$i]["CS"])); //Refund_Reversal_Status
                $refund_reversal_timestamp = trim(str_replace("'", '', $worksheet[$i]["CT"])); //Refund_Reversal_TimeStamp
                $is_reversal = trim(str_replace("'", '', $worksheet[$i]["CW"])); //IS_REVERSAL

                // assigning missing status from config constants file
                // assigning missing status from config constants file
                $missingStatus = config('constants.missingStatus.StoreID');

                // getting the Not considered brands
                $NotconsiderArrayBrand = BrandNotConsider::select('brand')->where('isActive', '=', 1)->pluck('brand')->toArray();


                // if everything is correct
                if ($storeID != "" && $retekCode != "") {
                    $missingStatus = 'Valid';
                }

                // if the brand is in Not considered brands
                if (in_array($brand, $NotconsiderArrayBrand)) {
                    $missingStatus = 'NotValid';
                }

                // netamount = deposit - (-msfcomm - gst)
                $netAmount = $depositAmount - (-($msf_comm) - $totalGST);

                $data = array(
                    "storeID" => $storeID,
                    "retekCode" => $retekCode,
                    'colBank' => $colBank,
                    "brand" => $brand,
                    "mid" => $mid, // MID                     
                    "tid" => $tid, // POS_ID                      
                    "depositDt" => $depositDt, //Transaction_Date
                    "crDt" => $cr_dt, //Settled_Date
                    "depositAmount" => $depositAmount, // Amount
                    "msfComm" => $msf_comm, // Commission
                    "terminalName" => $terminal_name, // Link_Description
                    "bankRef" => $bank_ref, // Bank_Transaction_ID
                    "orderID" => $orderID, //Order_ID 
                    "storeName" => $store_name, ////Merchant_Name
                    "utrNo" => $utr_no, ////Payout_Date
                    "payoutDate" => $payout_date,
                    "externalSerialNo" => $external_serial_no, //External_Serial_No
                    "tranID" => $transaction_id, //Transaction_ID 
                    "instrument" => $instrument,
                    "creationDt" => $creation_dt,
                    "payType" => $pay_type, // Transaction_Type
                    "payerVPA" => $payer_vpa, // Customer_VPA
                    "payoutID" => $payout_id, //Payout_ID
                    "channel" => $channel, // Channel
                    "productCode" => $product_code, // Product_Code
                    "requestType" => $request_type, // Request_Type
                    "status" => $status, // Status
                    "settledAmount" => $settled_amount, //Settled_Amount
                    "pcf" => $pcf, //PCF
                    "pcfGst" => $pcf_gst, //PCF_GST
                    "responseCode" => $response_code, //Response_code
                    "responseMessage" => $response_message, //Response_message
                    "originalTxnValue" => $original_txn_value,
                    "prepaidCard" => $prepaid_card,
                    "additionalComments" => $additionalcomments,
                    "chargeTarget" => $charge_target,
                    "feeFactor" => $fee_factor,
                    "bankGateway" => $bankgateway,
                    "cardScheme" => $card_scheme,
                    "merRefId" => $mer_ref_id,
                    'totalGst' => $totalGST,
                    'netAmt' => $netAmount,
                    "merchantTrackID" => $merchant_trackid,
                    "arnNo" => $arn_no,
                    "commissionRate" => $commission_rate,
                    "acquiringServiceFee" => $acquiring_service_fee,
                    "acquiringServiceTax" => $acquiring_service_tax,
                    "platformServiceFee" => $platform_service_fee,
                    "platformServiceTax" => $platform_service_tax,
                    "userExpectedCreditDate" => $user_expected_credit_date,
                    "settleType" => $settle_type,
                    "merchantPaymentDetail1" => $merchant_payment_detail_1,
                    "customerID" => $customer_id,
                    "customerNickName" => $customer_nickname,
                    "paymentMobileNumber" => $payment_mobile_number,
                    "paymentEmailID" => $payment_email_id,
                    "issuingBank" => $issuing_bank,
                    "referenceTransactionID" => $reference_transaction_id,
                    "gmvTier" => $gmv_tier,
                    "transactionSlab" => $transaction_slab,
                    "refundType" => $refund_type,
                    "refundActor" => $refund_actor,
                    "splitFlag" => $split_flag,
                    "splitMID" => $split_mid,
                    "splitID" => $split_id,
                    "paymentReferenceNumber" => $payment_reference_number,
                    "isPNRValidated" => $is_prn_validated,
                    "prnValidateTime" => $prn_validate_time,
                    "creditDebitCardLast4Digits" => $creditdebit_card_last_4_digits,
                    "promoCode" => $promo_code,
                    "promoResponse" => $promo_response,
                    "cardBin" => $card_bin,
                    "customerDetails" => $customer_details,
                    "linkName" => $link_name,
                    "linkNotes" => $link_notes,
                    "promoDiscountType" => $promo_discount_type,
                    "promoAmount" => $promo_amount,
                    "totalBillAmount" => $total_bill_amount,
                    "instantDiscount" => $instant_discount,
                    "mlvAmount" => $mlv_amount,
                    "authCode" => $auth_code,
                    "rrn" => $rrn,
                    "promoCartAmount" => $promo_cart_amount,
                    "resellerID" => $reseller_id,
                    "resellerName" => $reseller_name,
                    "employeeID" => $employee_id,
                    "employeeName" => $employee_name,
                    "employeePhoneNo" => $employee_phoneno,
                    "employeeEmail" => $employee_email,
                    "orderReason" => $order_reason,
                    "customerAccountNumber" => $customer_account_number,
                    "customerBankIFSC" => $customer_bank_ifsc,
                    "templateID" => $template_id,
                    "templateName" => $template_name,
                    "foreignCurrency" => $foreign_currency,
                    "foreignCurrencyName" => $foreign_currency_name,
                    "foreignAmount" => $foreign_amount,
                    "exchangeRate" => $exchange_rate,
                    "userMarkupRate" => $user_markup_rate,
                    "refundSource" => $refund_source,
                    "subOrderStatus" => $sub_order_status,
                    "refundReversalID" => $refund_reversal_id,
                    "refundReversalStatus" => $refund_reversal_status,
                    "refundReversalTimestamp" => $refund_reversal_timestamp,
                    "isReversal" => $is_reversal,
                    "filename" => $file_1_name,
                    "createdBy" => Auth::id(),
                    "missingRemarks" => $missingStatus,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                );

                if (trim($worksheet[$i]["A"]) != '' && trim($worksheet[$i]["B"]) != '') {
                    if (MFLInwardWalletMISPayTMPos::updateOrInsert($data)) {
                        $this->repository->increamentInsertedCount();
                    }
                }
            }

            // finializing the logs
            $this->repository->finializeLog();

            return response()->json([
                'message' => 'Success',
                "data" => $this->generateHTML(function () use ($getorinilfilename) {
                    return MFLInwardWalletMISPayTMPos::select(
                        'depositAmount',
                        'missingRemarks',
                        DB::raw('ISNULL(depositDt, NULL) as depositDt'),
                        DB::raw('ISNULL(crDt, NULL) as crDt')
                    )->where('filename', 'like', '%' . $getorinilfilename . '%')->get();
                })
            ], 200);

        } catch (\Throwable $exception) {
            $this->repository->failedLog($exception);
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
