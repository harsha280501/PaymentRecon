<div><input class="form-check-input" wire:key="e1e1d21c8544d6ac21646b1148634e9113175d53ba00d865ce3e8f1d2eeb4347" x-model="checkedAll" @click="() => {
    if((@js($selectionHas).length != (new Set(selection)).size)) {
        selection = @js($selectionHas)
    } else {
        selection = []
    }
}" type="checkbox" value="" id="flexCheckDefault" /> <span style="font-weight: 800; font-size: 1.3em; color: rgb(104, 102, 102);">#</span></div> 