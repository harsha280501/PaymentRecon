<div class="col-4 mb-5" x-init="() => {
    $wire.filtering = false;
}">
    <table class="table table-bordered" id="table-collection">
        <tbody>
            <tr>
                <th data-bs-toggle="tooltip">Raw Tables (Cr.)</th>
                <th class="text-end"></th>
            </tr>
            <tr>
                <th>Tender</th>
                <th class="text-end">Cum. Amount</th>
            </tr>
            <tr class="bg-brown">
                <th>Cash</th>
                <td data-bs-toggle="tooltip" title="{{ 
                    number_format(((\App\Services\GeneralService::isnull($data['_raw']['HDFC'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['ICICI Cash'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBICASHMIS'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBICASHMumbai'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['AXIS Cash'] ?? 0, 0)) +
                    (\App\Services\GeneralService::isnull($data['_raw']['IDFC'] ?? 0, 0))), 2, '.', '')
                 }}">{{ 
                    number_format(((\App\Services\GeneralService::isnull($data['_raw']['HDFC'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['ICICI Cash'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBICASHMIS'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBICASHMumbai'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['AXIS Cash'] ?? 0, 0)) +
                    (\App\Services\GeneralService::isnull($data['_raw']['IDFC'] ?? 0, 0)))/ 10000000, 2, '.', '')
                 }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC'] ?? 0, 0)), 2, '.', '') }}">{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC'] ?? 0, 0)  / 10000000), 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>ICICI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['ICICI Cash'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['ICICI Cash'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI CashMIS</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['SBICASHMIS'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['SBICASHMIS'] ?? 0, 0)  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI Mumbai</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['SBICASHMumbai'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['SBICASHMumbai'] ?? 0, 0)  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>AXIS</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['AXIS Cash'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['AXIS Cash'] ?? 0, 0)  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>IDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['IDFC'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['IDFC'] ?? 0, 0)  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-warning">
                <th>Card Total</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_raw']['HDFC Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['ICICI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['AMEX Card'] ?? 0, 0))), 2, '.', '') }}" >{{ 
                    number_format(((\App\Services\GeneralService::isnull($data['_raw']['HDFC Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['ICICI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['AMEX Card'] ?? 0, 0)))  / 10000000, 2, '.', '')
                 }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['HDFC Card'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['HDFC Card'] ?? 0, 0)  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>ICICI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['ICICI Card'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['ICICI Card'] ?? 0, 0)  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['SBI Card'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['SBI Card'] ?? 0, 0)  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>AMEX</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['AMEX Card'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['AMEX Card'] ?? 0, 0)  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-success">
                <th>UPI total</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['HDFC UPI'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['HDFC UPI'] ?? 0, 0)  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['HDFC UPI'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_raw']['HDFC UPI'] ?? 0, 0)  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-info">
                <th>WALLET total</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PAYTM'] ?? 0, 0) + \App\Services\GeneralService::isnull($data['_raw']['WALLET PHONEPAY'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PAYTM'] ?? 0, 0) + \App\Services\GeneralService::isnull($data['_raw']['WALLET PHONEPAY'] ?? 0, 0))  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>PayTM</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PAYTM'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PAYTM'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>PHONEPE</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PHONEPAY'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PHONEPAY'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
        </tbody>
    </table>
</div>


<div class="col-4 mb-5">
    <table class="table table-bordered" id="table-collection">
        <tbody>
            <tr>
                <th data-bs-toggle="tooltip">All Bank Tables (Cr.)</th>
                <th class="text-end"></th>
            </tr>
            <tr>
                <th>Tender</th>
                <th class="text-end">Cum. Amount</th>
            </tr>
            <tr class="bg-brown">
                <th>Cash (All Bank Cash)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_allBank']['HDFC'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['ICICI Cash'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMIS'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMumbai'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['AXIS Cash'] ?? 0, 0)) +
                    (\App\Services\GeneralService::isnull($data['_allBank']['IDFC'] ?? 0, 0))), 2, '.', '') }}">{{ 
                    number_format(((\App\Services\GeneralService::isnull($data['_allBank']['HDFC'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['ICICI Cash'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMIS'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMumbai'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['AXIS Cash'] ?? 0, 0)) +
                    (\App\Services\GeneralService::isnull($data['_allBank']['IDFC'] ?? 0, 0))) / 10000000, 2, '.', '')
                 }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['HDFC'] ?? 0, 0), 2, '.', '') }}">{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['HDFC'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>ICICI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['ICICI Cash'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['ICICI Cash'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI CashMIS</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMIS'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMIS'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI Mumbai</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMumbai'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMumbai'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>AXIS</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['AXIS Cash'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['AXIS Cash'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>IDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['IDFC'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['IDFC'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-warning">
                <th>Card (All Bank Card)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_allBank']['HDFC Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['ICICI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['SBI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['AMEX Card'] ?? 0, 0))), 2, '.', '') }}" >{{ 
                    number_format(((\App\Services\GeneralService::isnull($data['_allBank']['HDFC Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['ICICI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['SBI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['AMEX Card'] ?? 0, 0))) / 10000000, 2, '.', '')
                 }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['HDFC Card'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['HDFC Card'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>ICICI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['ICICI Card'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['ICICI Card'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['SBI Card'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['SBI Card'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>AMEX</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['AMEX Card'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['AMEX Card'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-success">
                <th>UPI (All Bank Card)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['HDFC UPI'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['HDFC UPI'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['HDFC UPI'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['HDFC UPI'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-info">
                <th>WALLET (All Bank Wallet)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['WALLET PAYTM'] ?? 0, 0) + \App\Services\GeneralService::isnull($data['_allBank']['WALLET PHONEPAY'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['WALLET PAYTM'] ?? 0, 0) + \App\Services\GeneralService::isnull($data['_allBank']['WALLET PHONEPAY'] ?? 0, 0))  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>PayTM</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['WALLET PAYTM'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['WALLET PAYTM'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>PHONEPE</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['WALLET PHONEPAY'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_allBank']['WALLET PHONEPAY'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
        </tbody>
    </table>
</div>


<div class="col-4 mb-5">
    <table class="table table-bordered" id="table-collection">
        <tbody>
            <tr>
                <th data-bs-toggle="tooltip">Reconciliation Tables (Cr.)</th>
                <th class="text-end"></th>
            </tr>
            <tr>
                <th>Tender</th>
                <th class="text-end">Cum. Amount</th>
            </tr>
            <tr class="bg-brown">
                <th>Cash (Cash Reconciliation)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_recon']['HDFC'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['ICICI Cash'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['SBICASHMIS'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['SBICASHMumbai'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['AXIS Cash'] ?? 0, 0)) +
                    (\App\Services\GeneralService::isnull($data['_recon']['IDFC'] ?? 0, 0))), 2, '.', '') }}">{{ 
                    number_format(((\App\Services\GeneralService::isnull($data['_recon']['HDFC'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['ICICI Cash'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['SBICASHMIS'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['SBICASHMumbai'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['AXIS Cash'] ?? 0, 0)) +
                    (\App\Services\GeneralService::isnull($data['_recon']['IDFC'] ?? 0, 0))) / 10000000, 2, '.', '')
                 }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['HDFC'] ?? 0, 0), 2, '.', '') }}">{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['HDFC'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>ICICI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['ICICI Cash'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['ICICI Cash'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI CashMIS</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['SBICASHMIS'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['SBICASHMIS'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI Mumbai</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['SBICASHMumbai'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['SBICASHMumbai'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>AXIS</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['AXIS Cash'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['AXIS Cash'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>IDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['IDFC'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['IDFC'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-warning">
                <th>Card (Card Reconciliation)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_recon']['HDFC Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['ICICI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['SBI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['AMEX Card'] ?? 0, 0))) / 10000000, 2, '.', '') }}" >{{ 
                    number_format(((\App\Services\GeneralService::isnull($data['_recon']['HDFC Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['ICICI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['SBI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_recon']['AMEX Card'] ?? 0, 0))) / 10000000, 2, '.', '')
                 }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['HDFC Card'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['HDFC Card'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>ICICI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['ICICI Card'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['ICICI Card'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['SBI Card'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['SBI Card'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>AMEX</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['AMEX Card'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['AMEX Card'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-success">
                <th>UPI (Card Reconciliation)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['HDFC UPI'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['HDFC UPI'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['HDFC UPI'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['HDFC UPI'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-info">
                <th>WALLET (Wallet Reconciliation)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_recon']['WALLET PAYTM'] ?? 0, 0) + \App\Services\GeneralService::isnull($data['_recon']['WALLET PHONEPAY'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_recon']['WALLET PAYTM'] ?? 0, 0) + \App\Services\GeneralService::isnull($data['_recon']['WALLET PHONEPAY'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>PayTM</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['WALLET PAYTM'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['WALLET PAYTM'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>PHONEPE</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['WALLET PHONEPAY'] ?? 0, 0), 2, '.', '') }}" >{{ number_format(\App\Services\GeneralService::isnull($data['_recon']['WALLET PHONEPAY'] ?? 0, 0) / 10000000, 2, '.', '') }}</td>
            </tr>
        </tbody>
    </table>
</div>



<div class="col-4 mb-5">
    <table class="table table-bordered" id="table-collection">
        <tbody>
            <tr>
                <th data-bs-toggle="tooltip">Raw Tables vs All Bank Tables (Cr.)</th>
                <th class="text-end"></th>
            </tr>
            <tr>
                <th>Tender</th>
                <th class="text-end">Cum. Amount</th>
            </tr>
            <tr class="bg-brown">
                <th>Cash (Raw Table - All Bank Cash)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_raw']['HDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['HDFC'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['ICICI Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['ICICI Cash'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBICASHMIS'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['SBICASHMIS'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBICASHMumbai'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['SBICASHMumbai'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['AXIS Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['AXIS Cash'] ?? 0, 0)) +
                    (\App\Services\GeneralService::isnull($data['_raw']['IDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['IDFC'] ?? 0, 0))), 2, '.', '') }}">{{ 
                    number_format(((\App\Services\GeneralService::isnull($data['_raw']['HDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['HDFC'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['ICICI Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['ICICI Cash'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBICASHMIS'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['SBICASHMIS'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBICASHMumbai'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['SBICASHMumbai'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['AXIS Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['AXIS Cash'] ?? 0, 0)) +
                    (\App\Services\GeneralService::isnull($data['_raw']['IDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['IDFC'] ?? 0, 0))) / 10000000, 2, '.', '')
                 }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['HDFC'] ?? 0, 0)), 2, '.', '') }}">{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['HDFC'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>ICICI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['ICICI Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['ICICI Cash'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['ICICI Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['ICICI Cash'] ?? 0, 0))  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI CashMIS</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['SBICASHMIS'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['SBICASHMIS'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['SBICASHMIS'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['SBICASHMIS'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI Mumbai</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['SBICASHMumbai'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['SBICASHMumbai'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['SBICASHMumbai'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['SBICASHMumbai'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>AXIS</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['AXIS Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['AXIS Cash'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['AXIS Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['AXIS Cash'] ?? 0, 0))  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>IDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['IDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['IDFC'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['IDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['IDFC'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-warning">
                <th>Card (Raw Table - All Bank Card)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_raw']['HDFC Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['HDFC Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['ICICI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['ICICI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['SBI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['AMEX Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['AMEX Card'] ?? 0, 0))), 2, '.', '') }}" >{{ 
                    number_format(((\App\Services\GeneralService::isnull($data['_raw']['HDFC Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['HDFC Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['ICICI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['ICICI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['SBI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['AMEX Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['AMEX Card'] ?? 0, 0))) / 10000000, 2, '.', '')
                 }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['HDFC Card'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['HDFC Card'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>ICICI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['ICICI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['ICICI Card'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['ICICI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['ICICI Card'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['SBI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['SBI Card'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['SBI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['SBI Card'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>AMEX</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['AMEX Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['AMEX Card'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['AMEX Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['AMEX Card'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-success">
                <th>UPI (Raw Table - All Bank Card)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC UPI'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['HDFC UPI'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC UPI'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['HDFC UPI'] ?? 0, 0))  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC UPI'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['HDFC UPI'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC UPI'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['HDFC UPI'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-info">
                <th>WALLET (Raw Table - All Bank Wallet)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_raw']['WALLET PAYTM'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['WALLET PAYTM'] ?? 0, 0)) + (\App\Services\GeneralService::isnull($data['_raw']['WALLET PHONEPAY'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['WALLET PHONEPAY'] ?? 0, 0))), 2, '.', '') }}" >{{ number_format(((\App\Services\GeneralService::isnull($data['_raw']['WALLET PAYTM'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['WALLET PAYTM'] ?? 0, 0)) + (\App\Services\GeneralService::isnull($data['_raw']['WALLET PHONEPAY'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['WALLET PHONEPAY'] ?? 0, 0))) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>PayTM</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PAYTM'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['WALLET PAYTM'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PAYTM'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['WALLET PAYTM'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>PHONEPE</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PHONEPAY'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['WALLET PHONEPAY'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PHONEPAY'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_allBank']['WALLET PHONEPAY'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
        </tbody>
    </table>
</div>



<div class="col-4 mb-5">
    <table class="table table-bordered" id="table-collection">
        <tbody>
            <tr>
                <th data-bs-toggle="tooltip">Raw Tables vs Reconciliation Tables (Cr.)</th>
                <th class="text-end"></th>
            </tr>
            <tr>
                <th>Tender</th>
                <th class="text-end">Cum. Amount</th>
            </tr>
            <tr class="bg-brown">
                <th>Cash (Raw Table - Cash Reconciliation)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_raw']['HDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['ICICI Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Cash'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBICASHMIS'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMIS'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBICASHMumbai'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMumbai'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['AXIS Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AXIS Cash'] ?? 0, 0)) +
                    (\App\Services\GeneralService::isnull($data['_raw']['IDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['IDFC'] ?? 0, 0))), 2, '.', '') }}">{{ 
                    number_format(((\App\Services\GeneralService::isnull($data['_raw']['HDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['ICICI Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Cash'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBICASHMIS'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMIS'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBICASHMumbai'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMumbai'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['AXIS Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AXIS Cash'] ?? 0, 0)) +
                    (\App\Services\GeneralService::isnull($data['_raw']['IDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['IDFC'] ?? 0, 0))) / 10000000, 2, '.', '')
                 }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC'] ?? 0, 0)), 2, '.', '') }}">{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>ICICI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['ICICI Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Cash'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['ICICI Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Cash'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI CashMIS</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['SBICASHMIS'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMIS'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['SBICASHMIS'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMIS'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI Mumbai</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['SBICASHMumbai'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMumbai'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['SBICASHMumbai'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMumbai'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>AXIS</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['AXIS Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AXIS Cash'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['AXIS Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AXIS Cash'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>IDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['IDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['IDFC'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['IDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['IDFC'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-warning">
                <th>Card (Raw Table - Card Reconciliation)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_raw']['HDFC Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['ICICI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['AMEX Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AMEX Card'] ?? 0, 0))), 2, '.', '') }}" >{{ 
                    number_format(((\App\Services\GeneralService::isnull($data['_raw']['HDFC Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['ICICI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['SBI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_raw']['AMEX Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AMEX Card'] ?? 0, 0))) / 10000000, 2, '.', '')
                 }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC Card'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC Card'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>ICICI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['ICICI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Card'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['ICICI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Card'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['SBI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBI Card'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['SBI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBI Card'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>AMEX</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['AMEX Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AMEX Card'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['AMEX Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AMEX Card'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-success">
                <th>UPI (Raw Table - Card Reconciliation)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC UPI'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC UPI'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC UPI'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC UPI'] ?? 0, 0))  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC UPI'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC UPI'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['HDFC UPI'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC UPI'] ?? 0, 0))  / 10000000, 2, '.', '')}}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-info">
                <th>WALLET (Raw Table - Wallet Reconciliation)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_raw']['WALLET PAYTM'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PAYTM'] ?? 0, 0)) + (\App\Services\GeneralService::isnull($data['_raw']['WALLET PHONEPAY'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PHONEPAY'] ?? 0, 0))), 2, '.', '') }}" >{{ number_format(((\App\Services\GeneralService::isnull($data['_raw']['WALLET PAYTM'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PAYTM'] ?? 0, 0)) + (\App\Services\GeneralService::isnull($data['_raw']['WALLET PHONEPAY'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PHONEPAY'] ?? 0, 0))) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>PayTM</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PAYTM'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PAYTM'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PAYTM'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PAYTM'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>PHONEPE</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PHONEPAY'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PHONEPAY'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_raw']['WALLET PHONEPAY'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PHONEPAY'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
        </tbody>
    </table>
</div>


{{-- All bank vs reconiliation --}}
<div class="col-4 mb-5">
    <table class="table table-bordered" id="table-collection">
        <tbody>
            <tr>
                <th data-bs-toggle="tooltip">All Bank Tables vs Reconciliation Tables (Cr.)</th>
                <th class="text-end"></th>
            </tr>
            <tr>
                <th>Tender</th>
                <th class="text-end">Cum. Amount</th>
            </tr>
            <tr class="bg-brown">
                <th>Cash (All Bank Cash - Cash Reconciliation)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_allBank']['HDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['ICICI Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Cash'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMIS'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMIS'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMumbai'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMumbai'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['AXIS Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AXIS Cash'] ?? 0, 0)) +
                    (\App\Services\GeneralService::isnull($data['_allBank']['IDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['IDFC'] ?? 0, 0))), 2, '.', '') }}">{{ 
                    number_format(((\App\Services\GeneralService::isnull($data['_allBank']['HDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['ICICI Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Cash'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMIS'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMIS'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMumbai'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMumbai'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['AXIS Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AXIS Cash'] ?? 0, 0)) +
                    (\App\Services\GeneralService::isnull($data['_allBank']['IDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['IDFC'] ?? 0, 0))) / 10000000, 2, '.', '')
                 }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['HDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC'] ?? 0, 0)), 2, '.', '') }}">{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['HDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>ICICI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['ICICI Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Cash'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['ICICI Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Cash'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI CashMIS</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMIS'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMIS'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMIS'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMIS'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI Mumbai</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMumbai'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMumbai'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['SBICASHMumbai'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBICASHMumbai'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>AXIS</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['AXIS Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AXIS Cash'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['AXIS Cash'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AXIS Cash'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>IDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['IDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['IDFC'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['IDFC'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['IDFC'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-warning">
                <th>Card (All Bank Card - Card Reconciliation)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_allBank']['HDFC Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['ICICI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['SBI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['AMEX Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AMEX Card'] ?? 0, 0))), 2, '.', '') }}" >{{ 
                    number_format(((\App\Services\GeneralService::isnull($data['_allBank']['HDFC Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['ICICI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['SBI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBI Card'] ?? 0, 0)) + 
                    (\App\Services\GeneralService::isnull($data['_allBank']['AMEX Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AMEX Card'] ?? 0, 0))) / 10000000, 2, '.', '')
                 }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['HDFC Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC Card'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['HDFC Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC Card'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>ICICI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['ICICI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Card'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['ICICI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['ICICI Card'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>SBI</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['SBI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBI Card'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['SBI Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['SBI Card'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>AMEX</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['AMEX Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AMEX Card'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['AMEX Card'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['AMEX Card'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-success">
                <th>UPI  (All Bank Card - Card Reconciliation)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['HDFC UPI'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC UPI'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['HDFC UPI'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC UPI'] ?? 0, 0))  / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>HDFC</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['HDFC UPI'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC UPI'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['HDFC UPI'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['HDFC UPI'] ?? 0, 0))  / 10000000, 2, '.', '')}}</td>
            </tr>
            <tr class="empty-row">
                <th></th>
                <td></td>
            </tr>
            <tr class="bg-info">
                <th>WALLET  (All Bank Wallet - Wallet Reconciliation)</th>
                <td data-bs-toggle="tooltip" title="{{ number_format(((\App\Services\GeneralService::isnull($data['_allBank']['WALLET PAYTM'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PAYTM'] ?? 0, 0)) + (\App\Services\GeneralService::isnull($data['_allBank']['WALLET PHONEPAY'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PHONEPAY'] ?? 0, 0))), 2, '.', '') }}" >{{ number_format(((\App\Services\GeneralService::isnull($data['_allBank']['WALLET PAYTM'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PAYTM'] ?? 0, 0)) + (\App\Services\GeneralService::isnull($data['_allBank']['WALLET PHONEPAY'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PHONEPAY'] ?? 0, 0))) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>PayTM</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['WALLET PAYTM'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PAYTM'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['WALLET PAYTM'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PAYTM'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
            <tr>
                <th>PHONEPE</th>
                <td data-bs-toggle="tooltip" title="{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['WALLET PHONEPAY'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PHONEPAY'] ?? 0, 0)), 2, '.', '') }}" >{{ number_format((\App\Services\GeneralService::isnull($data['_allBank']['WALLET PHONEPAY'] ?? 0, 0) - \App\Services\GeneralService::isnull($data['_recon']['WALLET PHONEPAY'] ?? 0, 0)) / 10000000, 2, '.', '') }}</td>
            </tr>
        </tbody>
    </table>
</div>
