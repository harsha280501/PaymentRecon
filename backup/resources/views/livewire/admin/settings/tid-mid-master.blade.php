<div>
    <div class="row mb-4">
        <div class="col-lg-9">
            <ul class="nav nav-tabs justify-content-start" role="tablist">
                <li class="nav-item">
                    <a wire:click="switchTab('amexmid')" class="nav-link @tab('amexmid') active tab-active @endtab" data-bs-toggle="tab" href="#" role="tab" style="font-size: .8em !important">AMEX MID
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:click="switchTab('icicimid')" class="nav-link @tab('icicimid') active tab-active @endtab" data-bs-toggle="
                            tab" href="#" role="tab" style="font-size: .8em !important">
                        ICICI MID
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:click="switchTab('sbimis')" class="nav-link @tab('sbimis') active tab-active @endtab" data-bs-toggle="
                            tab" href="#" role="tab" style="font-size: .8em !important">
                        SBI MIS
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:click="switchTab('hdfctid')" class="nav-link @tab('hdfctid') active tab-active @endtab" data-bs-toggle="
                            tab" href="#" role="tab" style="font-size: .8em !important">
                        HDFC TID
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-lg-3 d-flex align-items-center justify-content-end">
            @tab('amexmid')
            <div class="btn-group mb-1">
                <div class="mb-2" style="float: right;">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#amexCreate">Add
                        Amex</button>
                </div>
            </div>
            <x-app.admin.settings.tid-mid-master.amexmid-create-popup id="amexCreate" />
            @endtab
            @tab('icicimid')
            <div class="btn-group mb-1">
                <div class="mb-2" style="float: right;">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#iciciCreate">Add
                        Icici</button>
                </div>
            </div>
            <x-app.admin.settings.tid-mid-master.icicimid-create-popup id="iciciCreate" />
            @endtab
            @tab('sbimis')
            <div class="btn-group mb-1">
                <div class="mb-2" style="float: right;">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sbiCreate">Add
                        Sbi</button>
                </div>
            </div>
            <x-app.admin.settings.tid-mid-master.sbimid-create-popup id="sbiCreate" />
            @endtab
            @tab('hdfctid')
            <div class="btn-group mb-1">
                <div class="mb-2" style="float: right;">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#hdfcCreate">Add
                        Hdfc</button>
                </div>
            </div>
            <x-app.admin.settings.tid-mid-master.hdfctid-create-popup id="hdfcCreate" />
        </div>
        @endtab
    </div>


    <div class="col-lg-12">
        {{-- Main sales table --}}
        {{-- <div class="w-100" style="overflow-x: scroll"> --}}
        <x-scrollable.scrollable :dataset="$dataset">
            <x-scrollable.scroll-head>
                @tab('amexmid')
                <tr>
                    <th class="left">MID</th>
                    <th class="right">POS</th>
                    <th class="right">SAPCODE</th>
                    <th class="left">RETEKCODE</th>
                    <th class="right">BRANDNAME</th>
                    <th class="right">ACTION</th>
                </tr>
                @endtab

                @tab('icicimid')
                <tr>
                    <th class="left">MID</th>
                    <th class="right">POS</th>
                    <th class="right">SAPCODE</th>
                    <th class="left">RETEKCODE</th>
                    <th class="right">BRANDCODE</th>
                    <th class="right">Action</th>
                </tr>
                @endtab

                @tab('sbimis')
                <tr>
                    <th class="left">MID</th>
                    <th class="right">POS</th>
                    <th class="right">SAPCODE</th>
                    <th class="left">RETEKCODE</th>
                    <th class="right">BRANDNAME</th>
                    <th class="right">ACTION</th>
                </tr>
                @endtab

                @tab('hdfctid')
                <tr>
                    <th class="left">TID</th>
                    <th class="right">POS</th>
                    <th class="right">SAPCODE</th>
                    <th class="left">RETEKCODE</th>
                    <th class="right">BRANDNAME</th>
                    <th class="right">ACTION</th>
                </tr>
                @endtab


            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>

                @tab('amexmid')
                @foreach ($dataset as $data)
                <tr>
                    <td class="left"> {{ $data->MID }} </td>
                    <td class="right"> {{ $data->POS }} </td>
                    <td class="right"> {{ $data->sapCode }} </td>
                    <td class="left"> {{ $data->retekCode }} </td>
                    <td class="right"> {{ $data->brandName }} </td>
                    <td class="right"><a data-bs-toggle="modal" data-bs-target="#exampleModalCenter_{{ $data->amexMIDUID }}" href="#">Edit</a>
                    </td>
                </tr>
                <x-app.admin.settings.tid-mid-master.amexmid-update-popup :data="$data" />
                @endforeach
                @endtab

                @tab('icicimid')
                @foreach ($dataset as $data)
                <tr>
                    <td class="left"> {{ $data->MID }} </td>
                    <td class="right"> {{ $data->POS }} </td>
                    <td class="right"> {{ $data->sapCode }} </td>
                    <td class="left"> {{ $data->retekCode }} </td>
                    <td class="right"> {{ $data->brandCode }} </td>
                    <td>
                        <a href="#" style="font-size: 1.1em" data-bs-target="#exampleModalCenterSecondTab_{{ $data->iciciMIDUID }}" data-bs-toggle="modal">Edit</a>
                    </td>
                </tr>
                <x-app.admin.settings.tid-mid-master.icicimid-update-popup :data="$data" />
                @endforeach
                @endtab

                @tab('sbimis')
                @foreach ($dataset as $data)
                <tr>
                    <td class="left"> {{ $data->MID }} </td>
                    <td class="right"> {{ $data->POS }} </td>
                    <td class="right"> {{ $data->sapCode }} </td>
                    <td class="left"> {{ $data->retekCode }} </td>
                    <td class="right"> {{ $data->brandName }} </td>
                    <td>
                        <a href="#" style="font-size: 1.1em" data-bs-target="#exampleModalCenterThirdTab_{{ $data->sbiMIDUID }}" data-bs-toggle="modal">Edit</a>
                    </td>
                </tr>
                <x-app.admin.settings.tid-mid-master.sbimid-update-popup :data="$data" />
                @endforeach
                @endtab

                @tab('hdfctid')
                @foreach ($dataset as $data)
                <tr>
                    <td class="left"> {{ $data->TID }} </td>
                    <td class="right"> {{ $data->POS }} </td>
                    <td class="right"> {{ $data->sapCode }} </td>
                    <td class="left"> {{ $data->retekCode }} </td>
                    <td class="right"> {{ $data->brandName }} </td>
                    <td>
                        <a href="#" style="font-size: 1.1em" data-bs-target="#exampleModalCenterFourthTab_{{ $data->hdfcTIDUID }}" data-bs-toggle="modal">Edit</a>
                    </td>
                </tr>

                <x-app.admin.settings.tid-mid-master.hdfctid-update-popup :data="$data" />
                @endforeach
                @endtab
            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>
        {{-- </div> --}}
    </div>
</div>
