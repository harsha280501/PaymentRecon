<?php


namespace App\Traits;


/**
 * Livewire Page with Tabs
 */
trait HasTabs {


    /**
     * Switching between tabs
     * @param mixed $tab
     * @return void
     */
    public function switchTab($tab): void {
        $this->activeTab = $tab;
        $this->emit('resetAll');
        $this->emit('reset:all');

        // recalculate the height while switching tabs
        $this->emit('tabChanged');
        $this->resetExcept('activeTab');
    }


    /**
     * Get the Current Tab
     * @return string
     */
    public function current(): string {
        return $this->activeTab;
    }

}