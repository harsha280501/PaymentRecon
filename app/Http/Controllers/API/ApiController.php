<?php

namespace App\Http\Controllers\API;

use DB;
use Carbon\Carbon;

// Services
use App\Models\BankMSI;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Exports\BankMISExport;
use App\Services\GeneralService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Services\API\AllBankMisInsertService;

class ApiController extends Controller {

    private AllBankMisInsertService $service;

    public function __construct(AllBankMisInsertService $service) {
        $this->service = $service;
    }


    public function AllBankMisInsert(Request $request) {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required'
                    //'from' => 'required',
                    //'to' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {
                $data = $this->service->AllBankMisInsert($request);
                echo json_encode($data);
            }
        } catch (\Throwable $th) {
            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            echo json_encode($data);
        }
    }


    public function AllBankMisInsertCard(Request $request) {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required'
                    //'from' => 'required',
                    //'to' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {
                $data = $this->service->AllBankMisInsertCard($request);
                echo json_encode($data);
            }
        } catch (\Throwable $th) {
            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            echo json_encode($data);
        }
    }


    // Wallet

    public function allWalletInsert(Request $request) {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required'
                    //'from' => 'required',
                    //'to' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {
                $data = $this->service->AllWalletMisInsert($request);
                echo json_encode($data);
            }
        } catch (\Throwable $th) {
            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            echo json_encode($data);
        }
    }


    public function insertSalesCashReco(Request $request) {

        try {

            $from = $request->from;
            $to = $request->to;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required'
                   // 'from' => 'required',
                   // 'to' => 'required'

                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_SALESCASHRECO :PROC_TYPE,:from,:to', [
                    'PROC_TYPE' => 'StoreSalesCASHMIS',
                    'from' => $from,
                    'to' => $to

                ]));

                if ($result->isNotEmpty()) {
                    $data['code'] = 0;
                    $data['message'] = 'Successfully!';
                    $data['errorMessage'] = '';
                    $data['PROC_TYPE'] = $result;
                    $data['error'] = false;
                } else {
                    $data['code'] = null;
                    $data['message'] = "No data found.";
                    $data['PROC_TYPE'] = 'Not successfully!';
                    $data['error'] = true;
                }
                return $data;
            }
        } catch (\Throwable $th) {

            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            return $data;
        }
    }

    public function insertSalesCardReco(Request $request) {

        try {

            $bankType = $request->bankType;
            $from = $request->from;
            $to = $request->to;


            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required'
                    //'from' => 'required',
                    //'to' => 'required'

                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {


                $result = collect(\DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_SALESCARDRECO :PROC_TYPE,:from,:to', [
                    'PROC_TYPE' => $bankType,
                    'from' => $from,
                    'to' => $to


                ]));

                if ($result->isNotEmpty()) {
                    $data['code'] = 0;
                    $data['message'] = 'Successfully!';
                    $data['errorMessage'] = '';
                    $data['PROC_TYPE'] = $result;
                    $data['error'] = false;
                } else {
                    $data['code'] = null;
                    $data['message'] = "No data found.";
                    $data['PROC_TYPE'] = 'Not successfully!';
                    $data['error'] = true;
                }
                return $data;
            }
        } catch (\Throwable $th) {

            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            return $data;
        }
    }


    public function insertSalesWalletReco(Request $request) {

        try {


            $bankType = $request->bankType;
            $from = $request->from;
            $to = $request->to;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required'
                   // 'from' => 'required',
                   // 'to' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_SALESWALLETRECO :PROC_TYPE,:from,:to', [
                    'PROC_TYPE' => $bankType,
                    'from' => $from,
                    'to' => $to

                ]));

                if ($result->isNotEmpty()) {
                    $data['code'] = 0;
                    $data['message'] = 'Successfully!';
                    $data['errorMessage'] = '';
                    $data['PROC_TYPE'] = $result;
                    $data['error'] = false;
                } else {
                    $data['code'] = null;
                    $data['message'] = "No data found.";
                    $data['PROC_TYPE'] = 'Not successfully!';
                    $data['error'] = true;
                }
                return $data;
            }
        } catch (\Throwable $th) {

            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            return $data;
        }
    }



    public function insertCashBankStementReco(Request $request) {

        try {

            $bankType = $request->bankType;
            $from = $request->from;
            $to = $request->to;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required'
                    //'from' => 'required',
                    //'to' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_CASHMISBKSTRECO :PROC_TYPE,:from,:to', [
                    'PROC_TYPE' => $bankType,
                    'from' => $from,
                    'to' => $to,

                ]));

                if ($result->isNotEmpty()) {
                    $data['code'] = 0;
                    $data['message'] = 'Successfully!';
                    $data['errorMessage'] = '';
                    $data['PROC_TYPE'] = $result;
                    $data['error'] = false;
                } else {
                    $data['code'] = null;
                    $data['message'] = "No data found.";
                    $data['PROC_TYPE'] = 'Not successfully!';
                    $data['error'] = true;
                }
                return $data;
            }
        } catch (\Throwable $th) {

            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            return $data;
        }
    }



    public function insertCardBankStementReco(Request $request) {

        try {

            $bankType = $request->bankType;
            $from = $request->from;
            $to = $request->to;


            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required'
                    //'from' => 'required',
                   // 'to' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_CARDMISBANKSTRECO :PROC_TYPE,:from,:to', [
                    'PROC_TYPE' => $bankType,
                    'from' => $from,
                    'to' => $to,

                ]));

                if ($result->isNotEmpty()) {
                    $data['code'] = 0;
                    $data['message'] = 'Successfully!';
                    $data['errorMessage'] = '';
                    $data['PROC_TYPE'] = $result;
                    $data['error'] = false;
                } else {
                    $data['code'] = null;
                    $data['message'] = "No data found.";
                    $data['PROC_TYPE'] = 'Not successfully!';
                    $data['error'] = true;
                }
                return $data;
            }
        } catch (\Throwable $th) {

            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            return $data;
        }
    }



    public function mposCashSalesReco(Request $request) {

        try {

            $bankType = $request->bankType;
            $fromdate = $request->fromdate;
            $todate = $request->todate;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required'
                    //'fromdate' => 'required',
                    //'todate' => 'required'

                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_MPOSSALESCASHRECO :PROC_TYPE,:fromdate,:todate', [
                    'PROC_TYPE' => $bankType,
                    'fromdate' => $fromdate,
                    'todate' => $todate

                ]));

                if ($result->isNotEmpty()) {
                    $data['code'] = 0;
                    $data['message'] = 'Successfully!';
                    $data['errorMessage'] = '';
                    $data['PROC_TYPE'] = $result;
                    $data['error'] = false;
                } else {
                    $data['code'] = null;
                    $data['message'] = "No data found.";
                    $data['PROC_TYPE'] = 'Not successfully!';
                    $data['error'] = true;
                }
                return $data;
            }
        } catch (\Throwable $th) {

            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            return $data;
        }
    }


    public function mposTenderCashSalesReco(Request $request) {

        try {

            $bankType = $request->bankType;
            $fromdate = $request->from;
            $todate = $request->to;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required'
                    //'from' => 'required',
                    //'to' => 'required'

                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_COMMERCIALHEAD_INSERT_MPOSCashTenderBankDropCashMISReco :from,:to', [
                    'from' => $fromdate,
                    'to' => $todate

                ]));

                if ($result->isNotEmpty()) {
                    $data['code'] = 0;
                    $data['message'] = 'Successfully!';
                    $data['errorMessage'] = '';
                    $data['PROC_TYPE'] = $result;
                    $data['error'] = false;
                } else {
                    $data['code'] = null;
                    $data['message'] = "No data found.";
                    $data['PROC_TYPE'] = 'Not successfully!';
                    $data['error'] = true;
                }
                return $data;
            }
        } catch (\Throwable $th) {

            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            return $data;
        }
    }

    public function mposCardSalesReco(Request $request) {

        try {

            $bankType = $request->bankType;
            $fromdate = $request->fromdate;
            $todate = $request->todate;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required',
                    'fromdate' => 'required',
                    'todate' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_MPOSSALES_CARDRECO :PROC_TYPE,:fromdate,:todate', [
                    'PROC_TYPE' => $bankType,
                    'fromdate' => $fromdate,
                    'todate' => $todate

                ]));

                if ($result->isNotEmpty()) {
                    $data['code'] = 0;
                    $data['message'] = 'Successfully!';
                    $data['errorMessage'] = '';
                    $data['PROC_TYPE'] = $result;
                    $data['error'] = false;
                } else {
                    $data['code'] = null;
                    $data['message'] = "No data found.";
                    $data['PROC_TYPE'] = 'Not successfully!';
                    $data['error'] = true;
                }
                return $data;
            }
        } catch (\Throwable $th) {

            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            return $data;
        }
    }


    public function mposSalesWalletReco(Request $request) {

        try {

            $bankType = $request->bankType;
            $fromdate = $request->fromdate;
            $todate = $request->todate;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required',
                    'fromdate' => 'required',
                    'todate' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all("PROC_TYPE field required");
                $data['error'] = true;
                echo json_encode($data);
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_MPOSSALES_WALLETRECO :PROC_TYPE,:fromdate,:todate', [
                    'PROC_TYPE' => $bankType,
                    'fromdate' => $fromdate,
                    'todate' => $todate

                ]));

                if ($result->isNotEmpty()) {
                    $data['code'] = 0;
                    $data['message'] = 'Successfully!';
                    $data['errorMessage'] = '';
                    $data['PROC_TYPE'] = $result;
                    $data['error'] = false;
                } else {
                    $data['code'] = null;
                    $data['message'] = "No data found.";
                    $data['PROC_TYPE'] = 'Not successfully!';
                    $data['error'] = true;
                }
                return $data;
            }
        } catch (\Throwable $th) {

            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            return $data;
        }
    }

    public function TruncateSalesRecoTables(Request $request) {
        try {
            $PROC_TYPE = $request->PROC_TYPE;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'PROC_TYPE' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all("PROC_TYPE field required");
                $data['error'] = true;
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_TruncateSalesRecoTables :PROC_TYPE', [
                    'PROC_TYPE' => $PROC_TYPE

                ]));

                $data['code'] = 0;
                $data['message'] = 'Table truncated successfully!';
                $data['error'] = false;
            }
        } catch (\Throwable $th) {
            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
        }

        return $data;
    }


    public function TruncateBankStatementTables(Request $request) {
        try {
            $PROC_TYPE = $request->PROC_TYPE;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'PROC_TYPE' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all("PROC_TYPE field required");
                $data['error'] = true;
            } else {

                $result = collect(\DB::select('[PaymentMIS_PROC_SELECT_COMMERCIALHEAD_TruncatebankstatementTables] :PROC_TYPE', [
                    'PROC_TYPE' => $PROC_TYPE

                ]));

                $data['code'] = 0;
                $data['message'] = 'Table truncated successfully!';
                $data['error'] = false;
            }
        } catch (\Throwable $th) {
            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
        }

        return $data;
    }


    public function TruncateMposSalesTables(Request $request) {
        try {
            $PROC_TYPE = $request->PROC_TYPE;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'PROC_TYPE' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all("PROC_TYPE field required");
                $data['error'] = true;
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_TruncateMposSalesTables :PROC_TYPE', [
                    'PROC_TYPE' => $PROC_TYPE

                ]));

                $data['code'] = 0;
                $data['message'] = 'Table truncated successfully!';
                $data['error'] = false;
            }
        } catch (\Throwable $th) {
            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
        }

        return $data;
    }

    public function TruncateAllBankTables(Request $request) {
        try {
            $bankType = $request->bankType;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all("bankType field required");
                $data['error'] = true;
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_TruncateAllBankTables :PROC_TYPE', [
                    'PROC_TYPE' => $bankType

                ]));

                $data['code'] = 0;
                $data['message'] = 'Table truncated successfully!';
                $data['error'] = false;
            }
        } catch (\Throwable $th) {
            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
        }

        return $data;
    }

    public function TruncateApprovalTables(Request $request) {
        try {
            $bankType = $request->bankType;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all("bankType field required");
                $data['error'] = true;
            } else {

                $result = collect(\DB::select('[PaymentMIS_PROC_SELECT_COMMERCIALHEAD_TruncateApprovalTables] :PROC_TYPE', [
                    'PROC_TYPE' => $bankType

                ]));

                $data['code'] = 0;
                $data['message'] = 'Table truncated successfully!';
                $data['error'] = false;
            }
        } catch (\Throwable $th) {
            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
        }

        return $data;
    }



    public function SelectCash(Request $request) {

        try {


            $bankType = $request->bankType;
            $from = $request->from;
            $to = $request->to;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required',
                    // 'from' => 'required',
                    // 'to' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_SELECT_STOREID_NULL_DATA_CASH :PROC_TYPE,:from,:to', [
                    'PROC_TYPE' => $bankType,
                    'from' => $from,
                    'to' => $to

                ]));

                if ($result->isNotEmpty()) {
                    $data['code'] = 0;
                    $data['message'] = 'Successfully!';
                    $data['errorMessage'] = '';
                    $data['PROC_TYPE'] = 'Successfully!';
                    $data['error'] = false;
                } else {
                    $data['code'] = null;
                    $data['message'] = "No data found.";
                    $data['PROC_TYPE'] = 'Not successfully!';
                    $data['error'] = true;
                }
                return $data;
            }
        } catch (\Throwable $th) {

            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            return $data;
        }
    }


    public function SelectWallet(Request $request) {

        try {


            $bankType = $request->bankType;
            $from = $request->from;
            $to = $request->to;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required',
                    // 'from' => 'required',
                    // 'to' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_SELECT_STOREID_NULL_DATA_WALLET :PROC_TYPE,:from,:to', [
                    'PROC_TYPE' => $bankType,
                    'from' => $from,
                    'to' => $to

                ]));

                if ($result->isNotEmpty()) {
                    $data['code'] = 0;
                    $data['message'] = 'Successfully!';
                    $data['errorMessage'] = '';
                    $data['PROC_TYPE'] = 'Successfully!';
                    $data['error'] = false;
                } else {
                    $data['code'] = null;
                    $data['message'] = "No data found.";
                    $data['PROC_TYPE'] = 'Not successfully!';
                    $data['error'] = true;
                }
                return $data;
            }
        } catch (\Throwable $th) {

            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            return $data;
        }
    }

    public function SelectCard(Request $request) {

        try {


            $bankType = $request->bankType;
            $from = $request->from;
            $to = $request->to;

            $validateUser = Validator::make(
                $request->all(),
                [
                    'bankType' => 'required',
                    // 'from' => 'required',
                    // 'to' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                $data['code'] = null;
                $data['message'] = "Validation Errors";
                $data['errorMessage'] = $validateUser->errors()->all();
                $data['error'] = true;
                echo json_encode($data);
            } else {

                $result = collect(\DB::select('PaymentMIS_PROC_SELECT_STOREID_NULL_DATA_CARD :PROC_TYPE,:from,:to', [
                    'PROC_TYPE' => $bankType,
                    'from' => $from,
                    'to' => $to

                ]));

                if ($result->isNotEmpty()) {
                    $data['code'] = 0;
                    $data['message'] = 'Successfully!';
                    $data['errorMessage'] = '';
                    $data['PROC_TYPE'] = 'Successfully!';
                    $data['error'] = false;
                } else {
                    $data['code'] = null;
                    $data['message'] = "No data found.";
                    $data['PROC_TYPE'] = 'Not successfully!';
                    $data['error'] = true;
                }
                return $data;
            }
        } catch (\Throwable $th) {

            $data['code'] = null;
            $data['message'] = "";
            $data['errorMessage'] = $th->getMessage();
            $data['error'] = true;
            return $data;
        }
    }
}
