@props(['id', 'repo', 'repos'])

<div class="modal fade" id="{{ $id }}" tabindex="1" role="dialog" aria-labelledby="repoview" aria-hidden="true" style="max-height: 500px !important; width: 100%">
    <div class="modal-dialog repomodal" style="height: inherit; width: 100%" role="document">
        <div class="modal-content repocontent" style="height: inherit; width: 100%">
            <div class="modal-header">
                <h5 class="modal-title">View Details</h5>
            </div>
            <div class="modal-body">
                <div class="mb-5">
                    <label>Date : <b>{{\Carbon\Carbon::parse($repo->Date)->format('d-m-Y') }}</label></b>
                    <div class="row mb-3">
                    </div>
                </div>

                <div class="col-lg-12 col-md-12"></div>
                <div class="mb-2 px-2 d-flex" style="gap: 1em !important; flex-wrap: wrap">
                    @forelse($repos as $main)

                    <div class=" bg-light" style="border: 1px solid #00000017; border-radius: 5px; padding: .6em">
                        <div class="col-8">
                            <p class="text-left" style="color: #000">Filename: <br> <b>{{ $main->filename }}</b></p>
                        </div>

                        <div class="col">
                            @if($main->BankType == 'HDFC CARD')
                            <a href="{{ url('/') }}/storage/app/public/commercial/hdfccarddata/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'HDFC CASH')
                            <a href="{{ url('/') }}/storage/app/public/commercial/hdfcCashdata/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'ICICI CASH')
                            <a href="{{ url('/') }}/storage/app/public/commercial/iciciCashdata/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'ICICI CARD')

                            <a href="{{ url('/') }}/storage/app/public/commercial/iciciCarddata/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'SBI CASH')

                            <a href="{{ url('/') }}/storage/app/public/commercial/SbiCashdata/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'SBI CARD')

                            <a href="{{ url('/') }}/storage/app/public/commercial/SbiCarddata/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'HDFC UPI')
                            <a href="{{ url('/') }}/storage/app/public/commercial/hdfcCashdata/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'AXIS CASH')
                            <a href="{{ url('/') }}/storage/app/public/commercial/axisCashdata/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'AMEX CARD')
                            <a href="{{ url('/') }}/storage/app/public/commercial/amexdata/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'WALLET PHONEPAY')
                            <a href="{{ url('/') }}/storage/app/public/commercial/phonepaydata/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'WALLET PAYTM')
                            <a href="{{ url('/') }}/storage/app/public/commercial/PAYTMC/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'HDFC Bank Statement')
                            <a href="{{ url('/') }}/storage/app/public/commercial/BankStatement/HDFC/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'ICICI Bank Statement')
                            <a href="{{ url('/') }}/storage/app/public/commercial/BankStatement/ICICI/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'SBI Bank Statement')
                            <a href="{{ url('/') }}/storage/app/public/commercial/BankStatement/SBI/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'AXIS Bank Statement')
                            <a href="{{ url('/') }}/storage/app/public/commercial/BankStatement/AXIS/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>

                            @elseif($main->BankType == 'IDFC Bank Statement')
                            <a href="{{ url('/') }}/storage/app/public/commercial/BankStatement/IDFC/{{ $main->filename }}" download class="text-center" style="color: #000"><i class="fa fa-2x fa-download"></i></a>


                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-center mt-4">No Files to Display</p>

                    @endforelse
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn grey" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
