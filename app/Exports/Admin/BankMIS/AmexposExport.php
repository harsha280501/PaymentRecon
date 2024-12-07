<?php


namespace App\Exports\Admin\BankMIS;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AmexposExport implements FromCollection, WithHeadings
{

    public $data;
    public $type;

    public function __construct($data, $type)
    {
        $this->data = $data;
        $this->type = $type;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'CardMISAmexPosUID',
            'colBank',
            'acctNo',
            'merCode',
            'tid',
            'mid',
            'depositDt',
            'crDt',
            'depositAmount',
            'intnlAmt',
            'domesticAmt',
            'mdrRate',
            'msfComm',
            'cgstAmt',
            'sgstAmt',
            'igstAmt',
            'ugstAmt',
            'gstTotal',
            'netAmount',
            'GlTxn',
            'cardTypes',
            'cardNumber',
            'transactionType',
            'procDt]',
            'approvCode',
            'settlAmount',
            'servTax',
            'sbCess',
            'kkCess',
            'drCrType',
            'arnNo',
            'midCity',
            'recFmt',
            'batNbr',
            'tranId',
            'upValue',
            'merchantTrackid',
            'invoiceNumber',
            'gstnTransactionId',
            'udf1',
            'udf2',
            'udf3',
            'udf4',
            'udf5',
            'sequenceNumber',
            'tranType',
            'merchantName',
            'merchantVpa',
            'payerVpa',
            'orderId',
            'currency',
            'nameAndLoc',
            'mcc',
            'onusOffus',
            'penaltyMdrRate',
            'penaltyMdrAmt',
            'penaltyServiceTax',
            'cashbackAmt',
            'incMdrRate',
            'incAmt',
            'incServiceTax',
            'penaltySbc',
            'penaltyKcc',
            'branchCode',
            'circle',
            'CardType',
            'sponsorbank',
            'PenaltyGST',
            'GSTIN',
            'Paymentmode',
            'Interchange',
            'TranIdentifier',
            'SuperMID',
            'ParentMID',
            'AirlineTicketNumber',
            'AdjustmentType',
            'Retak code'

        ];
    }
}
