@foreach ($cashRecons as $data)
<tr>
    <td class="left"> {{ Carbon\Carbon::parse($data->transactionDate)->format('d-m-Y') }} </td>
    <td>{{ $data->storeID }}</td>
    <td>{{ $data->retekCode }}</td>
    <td>{{ $data->brand }}</td>
    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>

    <td>{{ $data->approvedDate }}</td>
    <td>{{ $data->approvedBy }}</td>
    <td>{{ $data->cardSale }}</td>
    <td>{{ $data->depositAmount }}</td>
    <td>{{ $data->diffSaleDeposit }}</td>
    <td class="right" 1style="font-weight: 700; color: green;"> {{ intval($data->saleReconDifferenceAmount) }} </td>
    <td class="right"><a data-bs-toggle="modal" data-bs-target="#exampleModalCenter_{{ $data->cardSalesRecoUID }}" href="#">View</a></td>
</tr>

<div class="modal fade" id="exampleModalCenter_{{ $data->cardSalesRecoUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">


    <div class="modal-dialog modal-dialog-centered " role="document" style="max-width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Card Sale Reconciliation History</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body">

                <form class="forms-sample">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Store ID : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->storeID }} </h5>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Store Name : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->{'Store Name'} }}</h5>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Location : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->Location }}</h5>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: -20px">

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Retek Code : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->retekCode }}</h5>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Brand : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->brand }}</h5>

                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Pickup Bank : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->collectionBank }}</h5>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: -20px; margin-bottom: -20px;">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Reconciliation Date : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{
                                                Carbon\Carbon::now()->format('d-m-Y')
                                                }}</h5>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>

                <h5>Reconciliation Window </h5>
                <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

                    <div class="row cash-pickup">
                        <div class="col-lg-3">
                            <h5>Sales Date</h5>
                        </div>
                        <div class="col-lg-3">
                            <h5>Sales Amount</h5>
                        </div>
                        <div class="col-lg-3">
                            <h5>Collection Amount</h5>
                        </div>
                        <div class="col-lg-3">
                            <h5>Difference [Sale-Collection]</h5>
                        </div>

                    </div>

                    <div class="row cash-pickup-item">
                        <div class="col-lg-3">
                            {{ Carbon\Carbon::parse($data->transactionDate)->format('d-m-Y') }}
                        </div>
                        <div class="col-lg-3">
                            {{ $data->cardSale }}
                        </div>
                        <div class="col-lg-3">
                            {{ $data->depositAmount }}
                        </div>
                        <div id="difference" class="col-lg-3">
                            {{ $data->diffSaleDeposit }}
                        </div>
                    </div>
                </section>
                <br>


                <h5>History</h5>
                <div class="scroll overflow-auto">

                    <div class="row flex-nowrap coll">
                        <div class="col-lg-2 p-1 border">
                            <h5>Item</h5>
                        </div>

                        <div class="col-lg-2 p-1 border">
                            <h5>Sale Amount</h5>
                        </div>

                        <div class="col-lg-2 p-1 border">
                            <h5>Deposit Amount</h5>
                        </div>


                        <div class="col-lg-2 p-1 border">
                            <h5>Store Remarks</h5>
                        </div>
                        <div class="col-lg-3 p-1 border">

                            <h5>Approval Status</h5>
                        </div>
                    </div>

                    @php

                    $historyRecords = DB::table('MFL_Outward_CardSalesReco_ApprovalProcess')
                    ->where('cardSalesRecoUID',$data->cardSalesRecoUID)
                    ->get();

                    @endphp

                    @foreach ($historyRecords as $item)

                    <div class="row flex-nowrap coll mt">
                        {{-- style="border-bottom: 1px solid #000"  --}}

                        <div class="col-lg-2  p-1 border">
                            {{$item->item}}
                        </div>

                        <div class="col-lg-2 p-1 border">
                            {{ $item->saleAmount}}
                        </div>
                        <div class="col-lg-2 p-1 border">
                            {{ $item->depositAmount}}
                        </div>
                        <div class="col-lg-2 p-1 border">
                            {{ $item->remarks}}
                        </div>
                        <div class="col-lg-3 p-1 border">
                            {{ $item->approveStatus}}
                        </div>
                    </div>

                    @endforeach
                </div>
                <br>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
@endforeach
