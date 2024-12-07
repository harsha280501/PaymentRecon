<?php


namespace App\Exports\CommercialHead\BankMIS;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WalletPaytmExport implements FromCollection, WithHeadings {

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
        return [
            'storeId',
            'retakeCode',
            'tid',
            'mid',
            'depositDt',
            'crDt',
            'depositAmount',
            'msfComm',
            'totalGst',
            'orderId',
            'terminalName',
            'bankRef',
            'storeName',
            'utrNo',
            'payoutDate',
            'externalSerialNo',
            'tranId',
            'instrument',
            'creationDt',
            'payType',
            'payerVpa',
            'payoutId',
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
            'additionalcomments',
            'chargeTarget',
            'feeFactor',
            'bankGateway',
            'cardScheme',
            'merRefId',
            'merchantTrackid',
            'arnNo',
            'commissionRate',
            'acquiringServiceFee',
            'acquiringServiceTax',
            'platformServiceFee',
            'platformServiceTax',
            'userExpectedCreditDate',
            'settleType',
            'merchantPaymentDetail1',
            'customerId',
            'customerNickname',
            'paymentMobileNumber',
            'paymentEmailId',
            'issuingBank',
            'referenceTransactionId',
            'gmvTier',
            'transactionSlab',
            'refundType',
            'refundActor',
            'splitFlag',
            'splitMid',
            'splitId',
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
            'resellerId',
            'resellerName',
            'employeeId',
            'employeeName',
            'employeePhoneno',
            'employeeEmail',
            'orderReason',
            'customerAccountNumber',
            'customerBankIfsc',
            'templateId',
            'templateName',
            'foreignCurrency',
            'foreignCurrencyName',
            'foreignAmount',
            'exchangeRate',
            'userMarkupRate',
            'refundSource',
            'subOrderStatus',
            'refundReversalId',
            'refundReversalStatus',
            'refundReversalTimestamp',
            'isReversal',
            'filename',
            'createdBy'
        ];
    }
}