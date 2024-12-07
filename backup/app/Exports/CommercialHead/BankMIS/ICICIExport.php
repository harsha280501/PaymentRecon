<?php


namespace App\Exports\CommercialHead\BankMIS;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ICICIExport implements FromCollection, WithHeadings {

    public $data;
    public $type;

    public function __construct($data, $type) {
        $this->data = $data;
        $this->type = $type;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }


    public function headings(): array {

        if ($this->type === "card") {
            return [
                'storeID',
                'retekCode',
                'colBank',
                'acctNo',
                'merCode',
                'tid',
                'mid',
                'depositDt',
                'crtDt',
                'depositAmount',
                'msfComm',
                'gstTotal',
                'netAmount',
                'cardTypes',
                'cardNumber',
                'transactionType',
                'procDt',
                'approvCode',
                'settlAmount',
                'drCrType',
                'arnNo',
                'batNbr',
                'tranId',
                'merchantTrackid',
                'fundingType',
                'merchantTariff',
                'merchantGrade',
                'terminalCapture',
                'originalMsgType',
                'udf1',
                'udf2',
                'udf3',
                'udf4',
                'udf5',
                'sequenceNumber',
                'tranType',
                'merchantName',
                'currency',
                'nameAndLoc',
                'mcc',
                'onusOffus',
                'CardType',
                'TranIdentifier',
                'SuperMID',
                'AirlineTicketNumber',
                'dccIndicator',
                'mcConvFee',
                'futureFundDate',
                'flightNo',
                'travelAgencyCode',
                'travelAgencyName',
                'recurTran',
                'customData',
                'transactionStatus',
                'filename',
                'createdBy',
            ];
        }

        return [
            'storeID',
            'retekCode',
            'colBank',
            'pkupPtCode',
            'tranType',
            'custCode',
            'prdCode',
            'locationName',
            '[depositDt',
            'adjDt',
            'crDt',
            'depSlipNo',
            'depositAmount',
            'adjAmount',
            'returnReason',
            'hirCode',
            'hirName',

            'locationShort',
            'clgType',
            'clgDt',
            'recDt',
            'rtnDt',
            'revDt',
            'realisationDt',

            'divisionCode',
            'divisionName',
            'adj',
            'noOfInst',
            'recoveredAmount',
            'subCustomerCode',
            'subCustomerName',
            'dS_Addl_InfoCode1',
            'dS_AddlInfo1',
            'dS_Addl_InfoCode2',
            'dS_AddlInfo2',
            'dS_Addl_InfoCode3',
            'dS_AddlInfo3',
            'dS_Addl_InfoCode4',
            'dS_AddlInfo4',
            'dS_Addl_InfoCode5',
            'dS_AddlInfo5',
            'instSl',
            'instNo',
            'instDt',
            'instAmt',
            'instType',
            'instAmtBreakup',
            'adjAmt',
            'recoveredAmt',
            'drnOn',
            'drnOnLocation',
            'drnBk',
            'drnBr',
            'subCust',
            'subCustName',
            'drCod',
            'drawerName',
            'returnAmt',
            'insAddl_InfoCode1',
            'insAddlInfo1',
            'insAddl_InfoCode2',
            'insAddlInfo2',
            'insAddl_InfoCode3',
            'insAddlInfo3',
            'insAddl_InfoCode4',
            'insAddlInfo4',
            'insAddl_InfoCode5',
            'insAddlInfo5',
            'remarks1',
            'remarks2',
            'remarks3',
            'poolSl',
            'addlField1',
            'addlField2',
            'addlField3',
            'filename',
            'createdBy',
        ];
    }
}