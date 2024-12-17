<div class="row">
    <div class="col-lg-12">
        <x-scrollable.scrollable :dataset="$dataset">
            <x-scrollable.scroll-head>
                <tr>
                    <th>MPOS Date</th>
                    <th>Retek Code</th>
                    <th>Brand</th>
                    <th>Tender Amount</th>
                    <th>Bank Drop Amount</th>
                    <th>Deposit Amount</th>
                    <th>Difference[Tender-BankDrop]</th>
                    <th>Difference[BankDrop-Deposit]</th>
                    <th>Status</th>
                    <th>Reconciliation Status</th>
                    <th>Submit Recon</th>
                </tr>
            </x-scrollable.scroll-head>
            {{ $slot }}
        </x-scrollable.scrollable>
    </div>
</div>
