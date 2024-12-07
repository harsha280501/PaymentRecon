<div x-data>
    <x-app.commercial-head.exceptions.tabs :filtering="$filtering" :activeTab="$activeTab" />

    {{-- Filters --}}
    <div>
        <x-app.commercial-head.exceptions.filters :filtering="$filtering" :activeTab="$activeTab" :months="$_months" :stores="$stores" />
    </div>



    <x-scrollable.scrollable :dataset="$dataset">
        <x-scrollable.scroll-head>


            @if($activeTab == 'bankdrop-mismatch')
            <tr>
                <td style="text-align: center;" colspan="1"></td>
                <td style="text-align: center; background: #BFBFBF" colspan="5" >Month to Date</td>
                <td style="text-align: center; background: #61CBF3" colspan="5">Year to Date</td>
            </tr>
            <tr>
                <td style="text-align: center;" colspan="1"></td>
                <td style="text-align: center; background: #D9D9D9" colspan="5">No. of Records</td>
                <td style="text-align: center; background: #A6C9EC" colspan="5">No. of Records</td>
            </tr>
            <tr>
                <td class="left">Store ID</td>
                <td class="right" style="background: #F2F2F2">Cash Tender</td>
                <td class="right" style="background: #F2F2F2">Bankdrop ID Generated</td>
                <td class="right" style="background: #F2F2F2">Bank drop ID Missing</td>
                <td class="right" style="background: #F2F2F2">Matched Bank Deposit Slip</td>
                <td class="right" style="background: #F2F2F2">Bank Deposit  Slip missing</td>

                <td class="right" style="background: #DAE9F8">Cash Tender</td>
                <td class="right" style="background: #DAE9F8">Bankdrop ID Generated</td>
                <td class="right" style="background: #DAE9F8">Bank drop ID Missing</td>
                <td class="right" style="background: #DAE9F8">Matched Bank Deposit Slip</td>
                <td class="right" style="background: #DAE9F8">Bank Deposit  Slip missing</td>
            </tr>
            @endif
        </x-scrollable.scroll-head>
        <x-scrollable.scroll-body>

            @if($activeTab == 'bankdrop-mismatch')

            @foreach ($dataset as $data)
            <tr>
                <td class="right"> {{ $data->storeID }} </td>

                <td class="right"> {{ $data->cashTenderM }} </td>
                <td class="right"> {{ $data->bankdropGeneratedM }} </td>
                <td class="right"> {{ $data->bankdropMissingM }} </td>
                <td class="right"> {{ $data->matchedBankdropSlipM }} </td>
                <td class="right"> {{ $data->depositSlipMissingM }} </td>

                <td class="right"> {{ $data->cashTenderY }} </td>
                <td class="right"> {{ $data->bankdropGeneratedY }} </td>
                <td class="right"> {{ $data->bankdropMissingY }} </td>
                <td class="right"> {{ $data->matchedBankdropSlipY }} </td>
                <td class="right"> {{ $data->depositSlipMissingY }} </td>
            </tr>
            @endforeach

            @endif

        </x-scrollable.scroll-body>

    </x-scrollable.scrollable>
</div>
