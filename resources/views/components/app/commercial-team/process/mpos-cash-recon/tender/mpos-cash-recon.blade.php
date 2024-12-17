<div class="row">
    <div class="col-lg-12">
        <x-scrollable.scrollable :dataset="$dataset">
            <x-scrollable.scroll-head>
                <tr>
                    <th>MPOS Date</th>
                    <th>Bank Drop ID</th>
                    <th>Tender Amount</th>
                    <th>Bank Drop Amount</th>
                    <th>Tender Difference Amount</th>
                    <th>Status</th>
                    <th>Reconciliation Status</th>
                    <th>Submit Recon</th>
                </tr>
            </x-scrollable.scroll-head>
            {{ $slot }}
        </x-scrollable.scrollable>
    </div>
</div>
