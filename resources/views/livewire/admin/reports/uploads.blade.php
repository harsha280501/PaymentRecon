<div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
    <section id="bankmis">

        <x-app.admin.reports.uploads.tabs :activeTab="$activeTab" />
        <x-app.admin.reports.uploads.filters :dataset="$dataset" :stores="$stores" :filtering="$filtering" />

        {{-- <!--Tab contents--->  --}}
        <div class="row">

            <x-scrollable.scrollable :dataset="$dataset">

                <x-scrollable.scroll-head>
                    <tr>
                        <th>Store ID</th>
                        <th>Retek Code</th>
                        <th>Deposit Date</th>
                        <th>Credit Date</th>
                        <th>Deposit Slip/ Merchand Code</th>
                        <th>Deposit Amount</th>
                        <th>FileName</th>
                    </tr>
                </x-scrollable.scroll-head>

                <x-scrollable.scroll-body>
                    @foreach ($dataset as $data)
                    <tr>
                        <td>{{ $data->storeID }}</td>
                        <td>{{ $data->retekCode }}</td>
                        <td>{{ Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                        <td>{{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}</td>
                        <td>{{ $data->slipNo }}</td>
                        <td>{{ $data->depositAmount }}</td>
                        <td>{{ $data->filename }}</td>
                    </tr>
                    @endforeach



                </x-scrollable.scroll-body>

            </x-scrollable.scrollable>
        </div>

    </section>

    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();


        document.addEventListener('livewire:load', function() {
            $j('#select1-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });
        });

    </script>
</div>
