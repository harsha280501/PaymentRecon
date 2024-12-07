<div>
    <div wire:ignore class="">
        <select id="{{ $keys }}-select2" class="custom-select select2 form-control select2-container" data-live-search="true" data-bs-toggle="dropdown" style="height: 15px !important; width: 250px !important">

        </select>
    </div>
</div>
<script>
    var $j = jQuery.noConflict();
    var main = $j(".select2-container").select2();

    // update dom
    function update(container) {
        const dataset = @json($dataset)

        container.empty()
        container.append(new Option('{{ $initialValue }}', '  '));

        dataset.forEach(data => {
            container.append(new Option(data['{{ $keys }}'], data['{{ $keys }}']));
        });
    }



    document.addEventListener('livewire:load', function() {

        update(main)

        $j("#{{ $keys }}-select2").on('change', function(e) {
            @this.set("{{ $keys }}", e.target.value);
            @this.set("filtering", true);
        });


        Livewire.on('resetAll', () => {
            update(main)
            main.val('').trigger('change')
            @this.set("filtering", false);
        });


    });

</script>
