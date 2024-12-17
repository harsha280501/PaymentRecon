<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>

        <tr style="background: #fff">
            <th style="background: rgba(0, 0, 0, 0.034)"></th>
            <th colspan="4">Sales</th>
            <th colspan="1" style="background: rgba(0, 0, 0, 0.021)"></th>
            <th colspan="7" style="background: rgba(0, 0, 0, 0.034)">Collection</th>
            <th colspan="4">Total</th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <th class="left">Deposit Date</th>
            <th class="left">Store ID</th>
            <th class="left">Retek Code</th>
            <th class="left">CARD</th>
            <th class="left">UPI</th>
            <th class="left">WALLET</th>
            <th class="left">TOTAL</th>
            <th class="left">Status</th>
            <th class="left">HDFC</th>
            <th class="left">AMEXPOS</th>
            <th class="left">SBI</th>
            <th class="left">ICICI</th>
            <th class="left">UPI</th>
            <th class="left">PHONEPE</th>
            <th class="left">PAYTM</th>

            <th class="left">Total Card Collection</th>
            <th class="left">Total UPI Collection</th>
            <th class="left">Total Wallet Collection</th>
            <th class="left">Total Collection</th>
            <th class="left">Difference</th>
        </tr>
    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>
