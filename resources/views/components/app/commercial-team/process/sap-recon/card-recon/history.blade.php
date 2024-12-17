{{-- History tab for store user process --}}
<div>
    @php
    $historyRecords = DB::table('MFL_Outward_CardSalesReco_ApprovalProcess')
    ->where('cardSalesRecoUID',$data->cardSalesRecoUID)
    ->orderBy('cardApprovalprocessUID', 'desc')
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
                    <label for="">Process Created at</label>
                    <p class="text-black" style="font-weight: 700">{{ Carbon\Carbon::parse($item->createdDate, 'UTC')->tz('Asia/Kolkata')->format('d-m-Y h:i A') }}</p>
                </div>

                <div class="w-100">
                    <label for="">Date of Deposit</label>
                    <p class="text-black" style="font-weight: 700">{{ Carbon\Carbon::parse($item->creditDate)->format('d-m-Y')}}</p>
                </div>

                <div class="w-100">
                    <label for="">Sale Amount</label>
                    <p class="text-black" style="font-weight: 700">₹ {{ number_format($item->saleAmount, 2) }}</p>
                </div>

                <div class="w-100">
                    <label for="">Approval Status</label>
                    <p class="text-black" style="font-weight: 700">
                        {{ ucfirst($item->approveStatus) }}
                    </p>
                </div>
            </div>

            <div class="d-flex justify-content-center align-items-start gap-3 mb-1 pt-2" style=" border-bottom: 2px solid #00000023; flex-wrap: nowrap">

                <div class="w-100">
                    <label for="">Bank Name</label>
                    <p class="text-black" style="font-weight: 700">{{ $item->bankName}}</p>
                </div>

                <div class="w-100">
                    <label for="" class="text-center">Support Document</label>
                    <div style="width: fit-content;">
                        <x-viewer.widget document="{{ url('/') }}/storage/app/public/reconciliation/card-reconciliation/store-card/{{ $item->supportDocupload }}" />
                    </div>
                </div>

                <div class="w-100">
                    <label for="">Remarks</label>
                    <p class="text-black" style="font-weight: 700">{{ $item->remarks }}</p>
                </div>

                <div class="w-100">
                    <label for="">Commercial Head Remarks</label>
                    <p class="text-black" style="font-weight: 700">{{ $item->cheadRemarks }}</p>
                </div>
            </div>
        </div>
    </div>

    @empty
    <p class="text-center text-black mt-3">History Not Found</p>
    @endforelse
</div>
