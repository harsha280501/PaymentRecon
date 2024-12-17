<div class="row">
    <div class="col-lg-12">
        <x-scrollable.scrollable :dataset="$dataset">
            <x-scrollable.scroll-head>
                <tr>
                    <th>Sale Date</th>
                    <th>Retek Code</th>
                    <th>Brand</th>
                    <th>Col Bank</th>
                    <th>Sales Amount</th>
                    <th>Collection Amount</th>
                    <th>Difference[sale-coll]</th>
                    <th>Status</th>
                    <th>Reconciliation Status</th>
                    <th>Submit Recon</th>
                </tr>
            </x-scrollable.scroll-head>
            {{ $slot }}
        </x-scrollable.scrollable>
    </div>
</div>
