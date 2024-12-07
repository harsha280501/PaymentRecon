<div class="w-100">


    <div class="row mt-3 mb-2">
        <div class="col d-flex gap-3">
            @if ($searchString !== "")
            <div class="">
                <button wire:click="back" style="background: transparent; outline: none; border: none; padding: .5em 1em; font-size: 1em">
                    <i class="fa fa-arrow-left"></i>
                </button>
            </div>
            @endif

            <select wire:model="column" class="select" style="border: none; font-size: .8em; color: #fff !important; height: 5vh; border-radius: 4px; display: inline; width: 130px" id="">
                <option value="ID">Select</option>
                <option value="BankType">BankType</option>
                <option value="filename">File Name</option>
                <option value="createdBy">Uploaded By</option>
                <option value="Date">Date</option>
            </select>

            <select wire:model="order" class=" select" style="border: none; font-size: .8em; color: #fff !important; height: 5vh; border-radius: 4px; width: 130px" id="">

                <option value="DESC">Descending</option>
                <option value="ASC">Ascending</option>
            </select>

            <form class="form d-flex gap-2" id="bank-mis-search-form">
                @csrf
                <input id="search" type="text" value="{{ $searchString }}" placeholder="Search..." class="form-control" style="height: 3.4vh !important" name="" id="">
                <button class="" style="outline: none; border: none; padding: 0 .5em; border-radius: 4px">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <x-scrollable.scrollable :dataset="$repos">
        <x-scrollable.scroll-head>
            <tr>
                <th>Bank Type</th>
                <th>File Name</th>
                <th>Uploaded By</th>
                <th>Date</th>
                <th class="right">Files Path</th>
            </tr>
        </x-scrollable.scroll-head>

        <x-scrollable.scroll-body>
            @forelse ($repos as $repo)
            @php
            $mainRepos = collect(DB::select('PaymentMIS_PROC_SELECT_REPOSITORY :PROC_TYPE, :PROC_Date, :BANK_TYPE', [
            'PROC_TYPE' => 'BankView',
            'PROC_Date' => $repo->Date,
            'BANK_TYPE' => $repo->BankType
            ]));

            @endphp

            <tr>
                <td>{{ $repo->BankType }}</td>
                <td>{{ $repo->filename }}</td>
                <td>{{ $repo->createdBy }} <b>({{ $repo->roleName }})</b></td>

                <td>{{ \Carbon\Carbon::parse($repo->Date)->format('d-m-Y')  }}</td>
                <td class="right"><a data-bs-toggle="modal" data-bs-target="#main{{ $repo->ID }}View" href="#">View</a></td>

            </tr>
            <x-modals.admin.bankmis-repository-view id="main{{ $repo->ID }}View" :repos="$mainRepos" :repo="$repo" />

            @empty

            @endforelse
        </x-scrollable.scroll-body>
    </x-scrollable.scrollable>


</div>
