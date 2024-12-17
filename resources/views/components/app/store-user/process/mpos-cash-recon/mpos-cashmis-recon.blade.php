<div class="row">
    <div class="col-lg-12">
        <x-scrollable.scrollable :dataset="$dataset">
            <x-scrollable.scroll-head>
                <tr>
                    <th>MPOS Date</th>
                    <th>Retek Code</th>
                    <th>Brand</th>
                    <th>Bank Drop Amount</th>
                    <th>Deposit Amount</th>
                    <th>Difference Amount</th>
                    <th>Status</th>
                    <th>Reconciliation Status</th>
                    <th>Submit Recon</th>
                </tr>
            </x-scrollable.scroll-head>
            {{ $slot }}
        </x-scrollable.scrollable>
    </div>
</div>
