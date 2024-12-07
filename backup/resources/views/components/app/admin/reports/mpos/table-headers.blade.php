<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>
        <tr>
            <td class="left"> Date</td>
            <td class="right"> Store ID </td>
            <td class="right"> RETEK Code </td>
             <td class="right"> Brand Desc </td> 
             <td class="right"> Total Tender Value </td> 
            {{-- <td class="left"> AMAZON </td> --}}
            <td class="left"> Amex Offline Card </td>
            <td class="left"> Cash </td>
            <td class="left"> Customer Advance </td>
            {{-- <td class="left"> Falcon </td> --}}
            <td class="left"> HDFC Reco </td>
            <td class="left"> HDFC UPI </td>
            <td class="left"> ICICI Reco </td>
            <td class="left"> Innoviti Card </td>
            <td class="left"> Innoviti Phonepe </td>
            <td class="left"> Innoviti UPI </td>
            {{-- <td class="left"> Online COD </td> --}}
            {{-- <td class="left"> Online Prepay </td> --}}
            {{-- <td class="left"> Online Return </td> --}}
            {{-- <td class="left"> Other CC </td> --}}
            <td class="left"> Paytm </td>
            <td class="left"> Paytm QR </td>
            <td class="left"> PhonePe </td>
            <td class="left"> Plutus </td>
            {{-- <td class="left"> QC GC Redemption </td> --}}
            <td class="left"> SBI Reco </td>
            {{-- <td class="left"> Store Credit </td> --}}
            {{-- <td class="left"> TataCliq </td> --}}
            {{-- <td class="left"> UBI Reco </td> --}}
            {{-- <td class="left"> Vouchergram </td> --}}
            {{-- <td class="left"> WESTBURYFL </td> --}}
            {{-- <td class="left"> OTHERS </td> --}}
        </tr>
    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>
