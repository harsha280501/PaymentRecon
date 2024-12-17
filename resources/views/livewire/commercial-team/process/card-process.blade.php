<section id="recent" class="process-page" x-data="{
    start: null,
    end: null,
    reset(){
        this.start = null
        this.end = null
    }
}">
    <div class="mt-2">
        <div class="my-2 d-flex d-flex-mob gap-2 align-items-center @tab('wallet') d-none @endtab">

            <div class=" @if (!$filtering) d-none @endif">
                <button wire:click="back" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </div>
            <div class="w-mob-100">
                <div wire:ignore>
                    <select id="select1-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 15px !important; width: 250px !important">
                        <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                        <option value="" class="dropdown-item">ALL</option>
                        @foreach ($cardStores as $bank)
                        @php
                        $bank = (array) $bank;
                        @endphp
                        <option class="dropdown-list" value="{{ $bank['storeID'] }}">{{ $bank['storeID'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div wire:ignore class="w-mob-100">
                <select id="select2-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 15px !important; width: 250px !important">
                    <option selected disabled value="" class="dropdown-item">SELECT BANK NAME</option>
                    <option value="" class="dropdown-item">ALL</option>
                    @foreach ($cardBanks as $bank)
                    @php
                    $bank = (array) $bank;
                    @endphp
                    <option class="dropdown-list" value="{{ $bank['banks'] }}">{{ $bank['banks'] }}</option>
                    @endforeach
                </select>
            </div>
            <x-filters.months :months="$_months" />
            <div class="w-mob-100">
                <x-filters.date-filter />
            </div>

            <x-filters.simple-export />
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">

            <x-scrollable.scrollable :dataset="$dataset">
                <x-scrollable.scroll-head>

                    @if ($activeTab == 'card')
                    <tr>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Sales Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                            </div>
                        </th>
                        <th>Deposit Date</th>
                        <th>Store ID</th>
                        <th>Retek Code</th>
                        <th>Brand Name</th>
                        <th>Col Bank</th>
                        <th>Status</th>
                        <th>Sales Amount</th>
                        <th>Deposit Amount</th>
                        <th>Difference</th>
                        <th>Recon Status</th>
                        <th>Submit Recon</th>
                    </tr>
                    @endif



                </x-scrollable.scroll-head>
                <x-scrollable.scroll-body>
                    @if ($activeTab == 'card')

                    @foreach ($dataset as $data)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($data->exDepDate)->format('d-m-Y') }}</td>
                        <td>{{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</td>
                        <td>{{ $data->storeID }}</td>
                        <td>{{ $data->retekCode }}</td>
                        <td>{{ $data->brand }}</td>
                        <td>{{ $data->pickupBank }}</td>
                        <td style="font-weight: 700; color: @if ($data->status === 'Matched') teal @else red @endif">
                            {{ $data->status }}
                        </td>
                        <td>{{ number_format($data->amount, 2) }}</td>
                        <td>{{ number_format($data->depositAmount, 2) }}</td>
                        <td>{{ number_format($data->diffSaleDeposit, 2) }}</td>
                        <td>{{ $data->reconStatus == 'disapprove' ? 'Rejected' : $data->reconStatus }}</td>
                        <td>
                            <a href="#" style="font-size: 1.1em" data-bs-toggle="modal" data-bs-target="#exampleModalCenter_{{ $data->cardSalesRecoUID }}">View</a>
                        </td>
                    </tr>

                    <div class="modal fade" id="exampleModalCenter_{{ $data->cardSalesRecoUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered " role="document" style="max-width:90%;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Card Sale Reconciliation</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form class="forms-sample">
                                        <div class="row" style="margin-bottom: -20px">
                                            <h5>Reconciliation dashboard</h5>
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
                                                        <h5>{{ $data->locationstore }}</h5>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom: -20px">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">
                                                        <h5>Pickup Bank : </h5>
                                                    </label>
                                                    <label for="exampleInputUsername1">
                                                        <h5>{{ $data->pickupBank }}</h5>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">
                                                        <h5>Reconciliation Date : </h5>
                                                    </label>
                                                    <label for="exampleInputUsername1">
                                                        <h5>{{ Carbon\Carbon::parse($data->processDt)->format('d-m-Y')
                                                            }}
                                                        </h5>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>



                                    <h5>Reconciliation Window </h5>
                                    <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

                                        @if ($data->reconStatus == 'disapprove')
                                        <div class="row cash-pickup">
                                            <div class="col-lg-2">
                                                <h5>Expected Deposit Date</h5>
                                            </div>
                                            <div class="col-lg-2">
                                                <h5>Sales Amount</h5>
                                            </div>
                                            <div class="col-lg-2">
                                                <h5>Collection Amount</h5>
                                            </div>
                                            <div class="col-lg-3">
                                                <h5>Difference [Sale-Collection]</h5>
                                            </div>
                                            <div class="col-lg-3">
                                                <h5>Reason for Disapproval</h5>
                                            </div>
                                        </div>

                                        <div class="row cash-pickup-item">
                                            <div class="col-lg-2">
                                                {{ Carbon\Carbon::parse($data->exDepDate)->format('d-m-Y') }}
                                            </div>
                                            <div class="col-lg-2">
                                                {{ number_format($data->amount, 2) }}
                                            </div>
                                            <div class="col-lg-2">
                                                {{ number_format($data->depositAmount, 2) }}
                                            </div>
                                            <div class="col-lg-3">
                                                {{ number_format($data->diffSaleDeposit, 2) }}
                                            </div>
                                            <div class="col-lg-3">
                                                {{ $data->approvalRemarks }}
                                            </div>
                                        </div>
                                        @else
                                        <div class="row cash-pickup">
                                            <div class="col-lg-3">
                                                <h5>Expected Deposit Date</h5>
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
                                                {{ Carbon\Carbon::parse($data->exDepDate)->format('d-m-Y') }}
                                            </div>
                                            <div class="col-lg-3">
                                                {{ number_format($data->amount, 2) }}
                                            </div>
                                            <div class="col-lg-3">
                                                {{ number_format($data->depositAmount, 2) }}
                                            </div>
                                            <div class="col-lg-3">
                                                {{ number_format($data->diffSaleDeposit, 2) }}
                                            </div>
                                        </div>
                                        @endif

                                    </section>
                                    <br>


                                    <h5>Manual Entry By Store for reconciliation</h5>
                                    <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

                                        <div class="row cash-pickup">
                                            <div class="col-lg-3">
                                                <h5>Item</h5>
                                            </div>
                                            <div class="col-lg-3 text-center">
                                                <h5>Sale Amount</h5>
                                            </div>

                                            <div class="col-lg-3 text-center">
                                                <h5>Supporting Documents</h5>
                                            </div>
                                            <div class="col-lg-3">
                                                <h5>Remarks</h5>
                                            </div>
                                        </div>

                                        @php
                                        $mainReconData = DB::table('MFL_Outward_CardSalesReco_ApprovalProcess')
                                        ->where('cardSalesRecoUID', $data->cardSalesRecoUID)
                                        ->get();
                                        @endphp

                                        @foreach ($mainReconData as $main)
                                        <div class="row mainUploadItems cash-pickup-item">
                                            <div class="col-lg-3  my-auto">
                                                {{ $main->item }}
                                            </div>
                                            <div class="col-lg-3 text-center my-auto">
                                                {{ number_format($main->saleAmount, 2) }}
                                            </div>

                                            <div class="col-lg-3 pt-2 d-flex gap-3 justify-content-center align-items-start">
                                                @if ($main->supportDocupload && $main->supportDocupload != 'undefined')
                                                <a download style="text-decoration: none" href="{{ url('/') }}/storage/app/public/reconciliation/card-reconciliation/store-card/{{ $main->supportDocupload }}">
                                                    <i class="fa-solid fa-download"></i> Download
                                                </a>
                                                @else
                                                <p class="text-center" style="margin-top: -10px">NO
                                                    FILE</p>
                                                @endif
                                            </div>

                                            <div class="col-lg-3">
                                                {{ $main->remarks }}
                                            </div>
                                        </div>
                                        @endforeach

                                        <div class="d-flex justify-content-end mt-4 mb-3 gap-3">
                                            <div class="form-group">
                                                <label for="">Sale Amount</label>
                                                <input disabled type="text" placeholder="Rs. 0.00" id="recon-amount" value="{{ number_format($data->amount, 2) }}" class="form-control">
                                            </div>


                                            <div class="form-group">
                                                <label for="">Deposit Amount</label>
                                                <input disabled type="text" placeholder="Rs. 0.00" id="recon-deposit-amount" value="{{ number_format($data->depositAmount, 2) }}" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Adjustment Amount</label>
                                                <input disabled type="text" placeholder="Rs. 0.00" id="recon-deposit-amount" value="{{ number_format($data->adjAmount, 2) }}" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Approval Status</label>
                                                <select id="approvalStatus" class="form-control" style="width: 300px">
                                                    <option selected value="">Select Approval Status
                                                    </option>
                                                    <option value="approve">Approve</option>
                                                    <option value="disapprove">Reject</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Remarks</label>
                                                <textarea id="remarks" style="width: 400px; height: 15vh;" type="text" placeholder="Enter your comments" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="modal-footer">
                                    <div class="footer-loading-btn" style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span>Loading ...</span>
                                    </div>

                                    <button x-data @click="(e) => handleFormData(e, 'exampleModalCenter_{{ $data->cardSalesRecoUID }}')" style="" data-id="{{ $data->cardSalesRecoUID }}" type="button" id="modalSubmitButton" class="btn btn-success green">Save</button>
                                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p class="text-center">Comming soon</p>
                    @endif

                </x-scrollable.scroll-body>
            </x-scrollable.scrollable>
        </div>
    </div>

    {{-- filter scripts --}}
    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {

            $j('#select2-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('bank', e.target.value);
            });

            $j('#select4-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('bank', e.target.value);
            });

            $j('#select1-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('storeId', e.target.value);
            });

            $j('#select3-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('storeId', e.target.value);
            });
        });

    </script>

</section>
