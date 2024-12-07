<?php


namespace App\Exports\CommercialTeam\BankMIS;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WalletPaytmExport implements FromCollection, WithHeadings
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
      'payTMPosUID',
      'sapCode',
      'retakeCode',
      'colBank',
      'storeId',
      'merCode',
      'tid',
      'mid',
      'depositDt',
      'crDt',
      'depositAmount',
      'msfComm',
      'cgstAmt',
      'sgstAmt',
      'igstAmt',
      'totalGst',
      'netAmt',
      'terminalName',
      'orderID',
      'storeName',
      'utrNo',
      'payoutDate',
      'externalSerialNo',
      'tranID',
      'instrument',
      'creationDt',
      'payType',
      'payerVPA',
      'payoutID',
      'channel',
      'productCode',
      'requestType',
      'status',
      'settledAmount',
      'pcf',
      'pcfGst',
      'responseCode',
      'responseMessage',
      'originalTxnValue',
      'prepaidCard',
      'additionalComments',
      'chargeTarget',
      'feeFactor',
      'bankGateway',
      'cardScheme',
      'merRefId',
      'merchantTrackID',
      'arnNo',
      'commissionRate',
      'acquiringServiceFee',
      'acquiringServiceTax',
      'platformServiceFee',
      'platformServiceTax',
      'userExpectedCreditDate',
      'settleType',
      'merchantPaymentDetail1',
      'customerID',
      'customerNickName',
      'paymentMobileNumber',
      'paymentEmailID',
      'issuingBank',
      'referenceTransactionID',
      'gmvTier',
      'transactionSlab',
      'refundType',
      'refundActor',
      'splitFlag',
      'splitMID',
      'splitID',
      'paymentReferenceNumber',
      'isPNRValidated',
      'prnValidateTime',
      'creditDebitCardLast4Digits',
      'promoCode',
      'promoResponse',
      'cardBin',
      'customerDetails',
      'linkName',
      'linkNotes',
      'promoDiscountType',
      'promoAmount',
      'totalBillAmount',
      'instantDiscount',
      'mlvAmount',
      'authCode',
      'rrn',
      'promoCartAmount',
      'resellerID',
      'resellerName',
      'employeeID',
      'employeeName',
      'employeePhoneNo',
      'employeeEmail',
      'orderReason',
      'customerAccountNumber',
      'customerBankIFSC',
      'templateID',
      'templateName',
      'foreignCurrency',
      'foreignCurrencyName',
      'foreignAmount',
      'exchangeRate',
      'userMarkupRate',
      'refundSource',
      'subOrderStatus',
      'refundReversalID',
      'refundReversalStatus',
      'refundReversalTimestamp',
      'isReversal',
      'phonepayRefId',
      'serviceProvider',
      'bankRef',
      'isActive',
      'createdBy',
      'createdDate'


        ];
    }
}
