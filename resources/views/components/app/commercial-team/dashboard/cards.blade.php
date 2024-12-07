<div>
    <div class="row g-6 mb-5">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Cash Total Record</span>
                            <div wire:key="{{ rand() }}" x-data="increamentsCounter('{{ $tile->cash_all_records }}')" x-init="updatecounter()" x-text="Math.floor(current)" style="color:#0d6efd; text-align: center;  font: 800 40px system-ui;"></div>

                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-color6 text-white text-lg rounded-circle" style="background-color:#0d6efd !important;">
                                <i class="fas fa-money-check-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 mb-0 text-sm" style="display: none;">
                        <span class="badge badge-pill bg-soft-success text-success me-2">
                            <i class="fa fa-arrow-up me-1" aria-hidden="true"></i>
                        </span>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Cash Matched</span>
                            <div wire:key="{{ rand() }}" x-data="increamentsCounter('{{ $tile->cash_matched_records }}')" x-init="updatecounter()" x-text="Math.floor(current)" style="color:#0fc30e; text-align: center;  font: 800 40px system-ui;"></div>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white text-lg rounded-circle" style="background-color:#0fc30e !important;">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 mb-0 text-sm" style="display: none;">
                        <span class="badge badge-pill bg-soft-success text-success me-2">
                            <i class="fa fa-arrow-up me-1" aria-hidden="true"></i>
                        </span>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 50%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Cash Not Matched</span>
                            <div wire:key="{{ rand() }}" x-data="increamentsCounter('{{ $tile->cash_not_matched_records }}')" x-init="updatecounter()" x-text="Math.floor(current)" id="number3" class="count3" style="color:#eb3030; text-align: center;  font: 800 40px system-ui;"></div>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-info text-white text-lg rounded-circle" style="background-color:#eb3030 !important;">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 mb-0 text-sm" style="display: none;">
                        <span class="badge badge-pill bg-soft-danger text-danger me-2">
                            <i class="fa fa-arrow-down me-1" aria-hidden="true"></i>
                        </span>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 50%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Wating for Approval</span>
                            <div wire:key="{{ rand() }}" x-data="increamentsCounter('{{ $tile->cash_waiting_approval_records }}')" x-init="updatecounter()" x-text="Math.floor(current)" style="color:#ffc107; text-align: center;  font: 800 40px system-ui;"></div>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-warning text-white text-lg rounded-circle">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 mb-0 text-sm" style="display: none;">
                        <span class="badge badge-pill bg-soft-success text-success me-2">
                            <i class="fa fa-arrow-up me-1" aria-hidden="true"></i>
                        </span>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 90%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-6 mb-5">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Card Total Record</span>
                            <div wire:key="{{ rand() }}" x-data="increamentsCounter('{{ $tile->card_all_records }}')" x-init="updatecounter()" x-text="Math.floor(current)" style="color:#0d6efd; text-align: center;  font: 800 40px system-ui;"></div>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-color6 text-white text-lg rounded-circle" style="background-color:#0d6efd !important;">
                                <i class="fa-regular fa-credit-card"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 mb-0 text-sm" style="display: none;">
                        <span class="badge badge-pill bg-soft-success text-success me-2">
                            <i class="fa fa-arrow-up me-1" aria-hidden="true"></i>
                        </span>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Card Matched</span>

                            <div wire:key="{{ rand() }}" x-data="increamentsCounter('{{ $tile->card_matched_records }}')" x-init="updatecounter()" x-text="Math.floor(current)" style="color:#0fc30e; text-align: center;  font: 800 40px system-ui;"></div>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white text-lg rounded-circle" style="background-color:#0fc30e !important;">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 mb-0 text-sm" style="display: none;">
                        <span class="badge badge-pill bg-soft-success text-success me-2">
                            <i class="fa fa-arrow-up me-1" aria-hidden="true"></i>
                        </span>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 50%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Card Not Matched</span>
                            <div wire:key="{{ rand() }}" x-data="increamentsCounter('{{ $tile->card_not_matched_records }}')" x-init="updatecounter()" x-text="Math.floor(current)" style="color:#eb3030; text-align: center;  font: 800 40px system-ui;"></div>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-info text-white text-lg rounded-circle" style="background-color:#eb3030 !important;">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 mb-0 text-sm" style="display: none;">
                        <span class="badge badge-pill bg-soft-danger text-danger me-2">
                            <i class="fa fa-arrow-down me-1" aria-hidden="true"></i>
                            <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 50%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Wating for Approval</span>
                            <div wire:key="{{ rand() }}" x-data="increamentsCounter('{{ $tile->card_waiting_approval_records }}')" x-init="updatecounter()" x-text="Math.floor(current)" style="color:#ffc107; text-align: center;  font: 800 40px system-ui;"></div>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-warning text-white text-lg rounded-circle">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 mb-0 text-sm" style="display: none;">
                        <span class="badge badge-pill bg-soft-success text-success me-2">
                            <i class="fa fa-arrow-up me-1" aria-hidden="true"></i>
                        </span>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 90%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-6 mb-5">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Wallet Total Record</span>
                            <div wire:key="{{ rand() }}" x-data="increamentsCounter('{{ $tile->wallet_all_records }}')" x-init="updatecounter()" x-text="Math.floor(current)" style="color:#0d6efd; text-align: center;  font: 800 40px system-ui;"></div>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-color6 text-white text-lg rounded-circle" style="background-color:#0d6efd !important;">
                                <i class="fa-regular fa-credit-card"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 mb-0 text-sm" style="display: none;">
                        <span class="badge badge-pill bg-soft-success text-success me-2">
                            <i class="fa fa-arrow-up me-1" aria-hidden="true"></i>
                        </span>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Wallet Matched</span>

                            <div wire:key="{{ rand() }}" x-data="increamentsCounter('{{ $tile->wallet_matched_records }}')" x-init="updatecounter()" x-text="Math.floor(current)" style="color:#0fc30e; text-align: center;  font: 800 40px system-ui;"></div>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white text-lg rounded-circle" style="background-color:#0fc30e !important;">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 mb-0 text-sm" style="display: none;">
                        <span class="badge badge-pill bg-soft-success text-success me-2">
                            <i class="fa fa-arrow-up me-1" aria-hidden="true"></i>
                        </span>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 50%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Wallet Not Matched</span>
                            <div wire:key="{{ rand() }}" x-data="increamentsCounter('{{ $tile->wallet_not_matched_records }}')" x-init="updatecounter()" x-text="Math.floor(current)" style="color:#eb3030; text-align: center;  font: 800 40px system-ui;"></div>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-info text-white text-lg rounded-circle" style="background-color:#eb3030 !important;">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 mb-0 text-sm" style="display: none;">
                        <span class="badge badge-pill bg-soft-danger text-danger me-2">
                            <i class="fa fa-arrow-down me-1" aria-hidden="true"></i>
                            <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 50%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Wating for Approval</span>
                            <div wire:key="{{ rand() }}" x-data="increamentsCounter('{{ $tile->wallet_waiting_approval_records }}')" x-init="updatecounter()" x-text="Math.floor(current)" style="color:#ffc107; text-align: center;  font: 800 40px system-ui;"></div>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-warning text-white text-lg rounded-circle">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 mb-0 text-sm" style="display: none;">
                        <span class="badge badge-pill bg-soft-success text-success me-2">
                            <i class="fa fa-arrow-up me-1" aria-hidden="true"></i>
                        </span>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 90%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
