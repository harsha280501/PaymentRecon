{{-- History tab for store user process --}}
<div>
    @php
    $historyRecords = DB::table('MLF_Outward_CashSalesReco_ApprovalProcess')
    ->where('cashSalesRecoUID',$data->mposCashSalesRecoUID)
    ->get();
    @endphp

    @forelse ($historyRecords as $item)

    <div style="background: rgba(211, 211, 211, 0.151); padding: 1em">

        <div class="p-3">
            <div class="d-flex justify-content-between align-items-center  mb-2">
                <h5 type="text" class="text-dark" data-name="item">{{$item->item}}</h5>
            </div>

            <div class="d-flex justify-content-center align-items-start gap-3 mb-1 pt-2" style="border-top: 2px solid #00000023; flex-wrap: nowrap">

                <div class="w-100">
                    <label for="">Sale Date</label>
                    <p class="text-black" style="font-weight: 700">{{ Carbon\Carbon::parse($item->saleDate)->format('d-m-Y')}}</p>
                </div>
                <div class="w-100">
                    <label for="">Deposit Date</label>
                    <p class="text-black" style="font-weight: 700">{{ Carbon\Carbon::parse($item->depositDate)->format('d-m-Y')}}</p>
                </div>

                <template x-if="'{{ $data->diffSaleDeposit }}' < 0">
                    <div class="w-100">
                        <label for="">Sale Amount</label>
                        <p class="text-black" style="font-weight: 700">₹ {{ number_format($item->saleAmount, 2) }}</p>
                    </div>
                </template>
                <template x-if="'{{ $data->diffSaleDeposit }}' > 0">
                    <div class="w-100">
                        <label for="">Deposit Amount</label>
                        <p class="text-black" style="font-weight: 700">₹ {{ number_format($item->depositAmount, 2) }}</p>
                    </div>
                </template>
                <div class="w-100">
                    <label for="">Slip Number</label>
                    <p class="text-black" style="font-weight: 700"> {{ $item->slipNumber }}</p>
                </div>
                <div class="w-100">
                    <label for="">Bank Name</label>
                    <p class="text-black" style="font-weight: 700">{{ $item->bankName }}</p>
                </div>
            </div>

            <div class="d-flex justify-content-center align-items-start gap-3 mb-1 pt-2" style=" border-bottom: 2px solid #00000023; flex-wrap: nowrap">


                <div class="w-100">
                    <label for="">Remarks</label>
                    <p class="text-black" style="font-weight: 700">{{ $item->remarks }}</p>
                </div>
                <div class="w-100">
                    <label for="">Approval Status</label>
                    <p class="text-black" style="font-weight: 700">{{ $data->reconStatus}}</p>
                </div>
                <div class="w-100">

                </div>
                <div class="w-100">

                </div>
                <div class="w-100">

                </div>
            </div>
        </div>
    </div>

    @empty
    <p class="text-center text-black mt-3">History Not Found</p>
    @endforelse
</div>
