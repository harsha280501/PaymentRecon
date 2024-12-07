<div x-data="{
    selection: [],
    checkedAll: false
}" x-init="() => {

    Alpine.nextTick(() => {
        $watch('selection', (main) => {
            if(((new Set(selection)).size == @js($selectionHas).length)) {
                checkedAll = true
            } else {
                checkedAll = false
            }
        })
    })
}" wire:key="ea8684d0ab5aa241f49ac61e6217e432c0242c80988429fcb05d5f172932c161">
    {{ $slot }}
</div>