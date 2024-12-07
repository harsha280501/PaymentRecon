<div x-init="() => {
    Livewire.on('livewire:message.success', ({
        message
    }) => {
        console.log(message);
        const _message = !message ? 'Success' : message
        succesMessageConfiguration(_message);
        window.location.reload()
    })

    Livewire.on('livewire:message.failure', ({
        message
    }) => {
        const _message = !message ? 'Success' : message
        errorMessageConfiguration(_message);
    })



    Livewire.on('file:imported', () => {
        succesMessageConfiguration('Store Master Imported Successfully')
        window.location.reload()
    })


    Livewire.on('file:created', () => {
        succesMessageConfiguration('Store Master Created Successfully')
        window.location.reload()
    })


    Livewire.on('create:failed', ({ message }) => {
        errorMessageConfiguration(message)
        return false;
    })


    Livewire.on('file:updated', () => {
        succesMessageConfiguration('Store Master Updated Successfully')
        window.location.reload()
    })
}">


    <div class="mt-2 mb-2">
        <x-app.commercial-head.settings.storemaster.filters :months="$_months" :filtering="$filtering" :stores="$stores" />
    </div>

 

    <x-livewire.CommercialHead.store-master-header :dataset="$datas">
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td class="left"> {{ $data->{'Store ID'} }} </td>
                <td class="left"> {{ $data->{'Store Name'} }} </td>
                <td class="left"> {{ $data->{'RETEK Code'} }} </td>
                <td class="left"> {{ $data->{'Brand Desc'} }} </td>
                <td class="left"> {{ $data->{'Region'} }} </td>
                <td class="left"> {{ $data->{'Pickup Bank'} }} </td>
                <td class="left"> {{ $data->{'Location'} }} </td>
                <td class="left"> {{ $data->{'City'} }} </td>
                <td class="left"> {{ $data->{'State'} }} </td>
                <td class="left"> {{ $data->{'Pin code'} }} </td>
                <td>
                    <a href="#" style="font-size: 1.1em" data-bs-toggle="modal" data-bs-target="#exampleModalCenter_{{ $data->{'Store ID'} }}">Edit</a>
                </td>
            </tr>

            <div wire:key="0dcbfa31a9d56b8600601f3ca85e48f3031608513093cdcfe93ede9d6a58d9ce">
                <x-app.commercial-head.settings.storemaster.update :data="$data" :message="$message" />
            </div>
            @endforeach

        </x-scrollable.scroll-body>
    </x-livewire.CommercialHead.store-master-header>

    <x-app.commercial-head.settings.storemaster.create :message="$message" />
    <x-app.commercial-head.settings.storemaster.store-master-import-popup id="storemasterUpload" :message="$message" />


    <script>
        var $j = jQuery.noConflict();

        function _selectFilterExtOne() {
            this.selectFilterOne = $j(this.$refs.selectFilterOne).select2();

            this.selectFilterOne.on("select2:select", (event) => {
                this.$wire.storeFrom = event.target.value;
                this.$wire.filtering = true;
            });

            this.$wire.on('resetAll', (event) => {
                this.selectFilterOne.val("").trigger("change");
            });
        }


        function _selectFilterExtFive() {
            this.selectFilterFive = $j(this.$refs.selectFilterFive).select2();

            this.selectFilterFive.on("select2:select", (event) => {
                this.$wire.storeTo = event.target.value;
                this.$wire.filtering = true;
            });

            this.$wire.on('resetAll', (event) => {
                this.selectFilterFive.val("").trigger("change");
            })
        }
    </script>
</div>
