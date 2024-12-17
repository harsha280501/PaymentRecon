<!--view modal popup-->
@props(['id', 'repo', 'repos'])

<div class="modal fade" id="{{ $id }}" tabindex="1" role="dialog" aria-labelledby="repoview" aria-hidden="true"
    style="max-height: 500px !important; width: 100%">
    <div class="modal-dialog" style="height: inherit; width: 100%" role="document">
        <div class="modal-content" style="height: inherit; width: 100%">
            <div class="modal-header">
                <h5 class="modal-title">View Details</h5>
            </div>
            <div class="modal-body">
                <div class="">
                    <label>Date : {{ $repo->importDate }}</label>
                    <div class="row mb-3">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-4">
                        <h5 class="text-center" style="color: #000">File name</h5>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <h5 class="text-center" style="color: #000">Download</h5>
                    </div>
                </div>

                <div class="row my-2"></div>

                @foreach ($repos as $main)
                <div class="row mb-2 px-2">
                    <div class="col-4">
                        <p class="text-left" style="color: #000">{{ $main->fileName }}</p>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4 text-center">
                        <a href="{{ url('/') }}/storage/app/public/admin/repository/{{ $main->fileName }}" download class="text-center"
                            style="color: #000"><i class="fa fa-download"></i></a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="modal-footer">
                <button type="button" class="btn grey" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
