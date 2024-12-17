<div class="addProcess">
    <div class="d-flex justify-content-center align-items-center" style="flex-direction: column">
        <template x-if="recons.length < 6">
            <div class="btn-group">
                <button type="button" class="dropdown-toggle d-flex btn mb-1" style="background: #e7e7e7; color: #000; width: fit-content" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Add Process
                </button>
                <div x-data="{
                    fillables: [
                        'Rectification Entry - Wallet MIS',
                        'Rectification Entry - Bank Statement'
                    ],
                    hasItem() {
                        return recons.map(item => item.item)
                    }, 
                    random(){
                        return Math.floor(Math.random() * 10000);
                    }, 

                    others() {
                        return (this.hasItem().filter(item => item == 'Other')).length < 4
                    }
                }" class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <template x-for="(rec, index) in fillables">
                        <template x-if="!hasItem().includes(rec)">
                            <a href="#" data-name="Others" class="dropdown-item p-1" style="font-size: 1em" @click="
                            create({
                                id: random(),
                                item: rec
                                })
                                hasItems.push(rec)
                                " x-text="rec"></a>
                        </template>
                    </template>
                    {{-- Other --}}

                    <template x-if="others()">
                        <a href="#" data-name="Others" class="dropdown-item p-1" style="font-size: 1em" @click="
                        create({
                            id: random(),
                            item: 'Other' 
                        })
                        ">Other Recons</a>
                    </template>
                </div>
            </div>
        </template>
        <template x-if="recons.length < 6">
            <span class="text-black">Maxium number of Other entries is limited to (4)</span>
        </template>
    </div>
</div>
