@foreach ($cashRecons as $data)
<tr>
    <td class="left"> {{ Carbon\Carbon::parse($data->transactionDate)->format('d-m-Y') }} </td>
    <td class="left"> {{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }} </td>

    <td>{{ $data->approvedDate }}</td>
    <td>{{ $data->approvedBy }}</td>
    <td style="text-align: right !important">{{ $data->cardSale }}</td>
    <td style="text-align: right !important">{{ $data->depositAmount }}</td>
    <td style="text-align: right !important">{{ $data->diffSaleDeposit }}</td>
    <td style="text-align: right !important">{{ $data->amount }}</td>
    <td class="right" 1style="font-weight: 700; color: green;"> {{ intval($data->saleReconDifferenceAmount) }} </td>
    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
    <td class="right"><a data-bs-toggle="modal" data-bs-target="#exampleModalCenter_{{ $data->walletSalesRecoUID }}" href="#">View</a></td>
</tr>

<div class="modal fade" id="exampleModalCenter_{{ $data->walletSalesRecoUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document" style="max-width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Wallet Sale Reconciliation History</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body">

                <form class="forms-sample">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Store ID : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->storeID }} </h5>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Retek Code : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->retekCode }}</h5>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Brand : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->brand }}</h5>

                                </label>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Location : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->Location }}</h5>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-3" style="margin-top: -20px">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Pickup Bank : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->collectionBank }}</h5>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-3" style="margin-top: -20px">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Reconciliation Date : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ Carbon\Carbon::parse($data->processDt)->format('d-m-Y') }}</h5>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>

                <h5>Reconciliation Window </h5>
                <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

                    <div class="row cash-pickup">
                        <div class="col-lg-3">
                            <h5>Expected Deposit Date</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Sales Amount</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Collection Amount</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Difference [Sale-Collection]</h5>
                        </div>
                        <div class="col-lg-3">
                            <h5>Approval Remarks</h5>
                        </div>

                    </div>

                    <div class="row cash-pickup-item">
                        <div class="col-lg-3">
                            {{ Carbon\Carbon::parse($data->transactionDate)->format('d-m-Y') }}
                        </div>
                        <div class="col-lg-2">
                            {{ $data->cardSale }}
                        </div>
                        <div class="col-lg-2">
                            {{ number_format($data->depositAmount, 2) }}
                        </div>
                        <div id="difference" class="col-lg-2">
                            {{ number_format($data->diffSaleDeposit, 2) }}
                        </div>

                        <div id="difference" class="col-lg-3">
                            {{ $data->approvalRemarks }}
                        </div>
                    </div>
                </section>
                <br>


                <h5>History</h5>
                <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

                    <div class="row cash-pickup">
                        <div class="col-lg-3">
                            <h5>Item</h5>
                        </div>

                        <div class="col-lg-2">
                            <h5>Reconciled Amount</h5>
                        </div>

                        <div class="col-lg-3">
                            <h5>Store Remarks</h5>
                        </div>

                        <div class="col-lg-2">
                            <h5>Approval Status</h5>
                        </div>

                        <div class="col-lg-2 text-center">
                            <h5>Supporting Documents</h5>
                        </div>
                    </div>

                    @php

                    $historyRecords = DB::table('MFL_Outward_WalletSalesReco_ApprovalProcess')
                    ->where('walletSalesRecoUID',$data->walletSalesRecoUID)
                    ->get();

                    @endphp

                    @foreach ($historyRecords as $item)

                    <div class="row mainUploadItems cash-pickup-item">
                        {{-- style="border-bottom: 1px solid #000"  --}}

                        <div class="col-lg-3">
                            {{$item->item}}
                        </div>

                        <div class="col-lg-2">
                            {{ number_format($item->saleAmount, 2) }}
                        </div>

                        <div class="col-lg-3">
                            {{ $item->remarks}}
                        </div>
                        <div class="col-lg-2">
                            {{ ucfirst($item->approveStatus) }}
                        </div>

                        <div class="col-lg-2 pt-2 d-flex gap-3 justify-content-center align-items-start">
                            @if ($item->supportDocupload && $item->supportDocupload != 'undefined')
                            <a download style="text-decoration: none" href="{{ url('/') }}/storage/app/public/reconciliation/wallet-reconciliation/store-wallet/{{ $item->supportDocupload }}">
                                <i class="fa-solid fa-download"></i> Download
                            </a>
                            @else
                            <p class="text-center" style="margin-top: -10px">NO FILE</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </section>
                <br>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
@endforeach
