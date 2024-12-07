<table class="table table-responsive table-info">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Date</th>
            <th class="right">Files Path</th>
        </tr>
    </thead>


    <tbody class="mb-3">
        @foreach ($repos as $repo)
        @php
        $mainRepos = collect(DB::select('PaymentMIS_PROC_SELECT_REPOSITORY :PROC_TYPE , :PROC_Date', [
        'PROC_TYPE' => 'View',
        'PROC_Date' => $repo->importDate,
        ]));

        // dd($mainRepos);
        @endphp

        <tr>
            <td>{{ $repo->srno }}</td>
            <td>{{ $repo->importDate }}</td>
            <td class="right"><a data-bs-toggle="modal" data-bs-target="#main{{ $repo->srno }}View" href="#">View</a></td>
        </tr>
        <x-modals.area-manager.repository-view id="main{{ $repo->srno }}View" :repos="$mainRepos" :repo="$repo" />
        @endforeach

    </tbody>
    {{ $repos->links() }}
</table>
