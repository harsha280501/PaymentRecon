<?php


namespace App\Traits;


/**
 * Livewire Page with Tabs
 */
trait UseMisModels {



    public function _generateQuery(string $tab, string $bank) {
        try {
            $modelMap = $this->_models();
            return $modelMap[$tab][$bank] ?? null;
        } catch (\Throwable $th) {
            return null;
        }
    }


    public function _models() {
        return [
            'cash' => [
                'HDFC' => \App\Models\MFLInwardCashMISHdfcPos::query(),
                'SBICASHMIS' => \App\Models\MFLInwardCashMIS2SBIPos::query(),
                'ICICI Cash' => \App\Models\MFLinwardCashMISIciciPos::query(),
                'IDFC' => \App\Models\MFLInwardCashMISIdfcPos::query(),
                'AXIS Cash' => \App\Models\MFLInwardCashMISAxisPos::query(),
            ],
        
            'card' => [
                'AMEX Card' => \App\Models\MFLInwardCardMISAmexPos::query(),
                'HDFC Card' => \App\Models\MFLInwardCardMISHdfcPos::query(),
                'ICICI Card' => \App\Models\MFLInwardCardMISIciciPos::query(),
                'SBI Card' => \App\Models\MFLInwardCardMISSBIPos::query(),
            ],
        
            'upi' => [
                'HDFC UPI' => \App\Models\MFLInwardUPIMISHdfcPos::query(),
            ],
        
            'wallet' => [
                'WALLET PAYTM' => \App\Models\MFLInwardWalletMISPayTMPos::query(),
                'WALLET PHONEPAY' => \App\Models\MFLInwardWalletMISPhonePayPos::query()
            ]
        ];
    }
}