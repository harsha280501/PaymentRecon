<?php

namespace App\Services;

use App\Models\Config;
use App\Models\Menu;
use App\Models\UserMenu;
use App\Models\Store;
use App\Traits\HandlesDates;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\MICICIMID;
use Illuminate\Support\Facades\DB;

class GeneralService
{

    use HandlesDates;

    /**
     * Elequent QueryBuiler
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function menuBuilder(): Builder
    {
        return UserMenu::orderBy('menuOrder', 'asc')
            ->where('isActive', 1)
            ->where('menuOrder', '!=', '0')
            ->where('roleUID', auth()->user()->roleUID);
    }

    /**
     * Users menus
     * @return \Illuminate\Database\Eloquent\Collection|array<Builder>
     */
    protected function userMenus()
    {
        return $this->menuBuilder()
            ->get(['menuUID', 'menuOrder']);
    }

    /**
     * Getting the menus from the database
     * Will be cache once fetched
     * @return mixed
     */
    public function menus()
    {
        // caching the data
        return Cache::remember('menus' . auth()->user()->userUID, 20000, function () {
            // Main data
            return $this->userMenus()->map(function ($menu) {

                return collect([
                    'menu' => Menu::where('isActive', 1)
                        ->where('menuUID', $menu->menuUID)
                        ->first(['menuName', 'menuURL', 'menuTitle', 'menuIcon', 'parentMenu']),

                    'subMenus' => Menu::where('isActive', 1)
                        ->where('parentMenu', $menu->menuUID)
                        ->get(['menuName', 'menuURL', 'menuTitle', 'menuIcon', 'parentMenu']),
                ]);
            })->toArray();
        });
    }


    /**
     * Summary of tabs
     * @return array
     */
    public function tabs()
    {
        // Current Url
        $url = explode(url('/'), url()->current());
        $url = is_null($url[1]) ? '/' : $url[1];
        // Getting the mai menu
        $mainMenu = Menu::where('isActive', 1)
            ->where('menuURL', $url)
            ->first();

        // Getting the sub menus
        $subMenus = Menu::orderBy('menuUID', 'asc')->where('isActive', 1)
            ->where('parentMenu', $mainMenu->menuUID)
            ->get();

        // if has parent menus
        $parentMenu = Menu::orderBy('menuUID', 'asc')->where('isActive', 1)
            ->where('menuUID', $mainMenu->parentMenu)
            ->first();

        // if has sibling menus
        $sideMenus = !is_null($parentMenu) ? Menu::orderBy('menuUID', 'asc')->where('isActive', 1)
            ->where('parentMenu', $parentMenu->menuUID)
            ->get() : [];

        // This could be messy
        return [
            'url' => $url,
            'menu' => $mainMenu,
            'subMenus' => $subMenus,
            'parent' => $parentMenu,
            'siblings' => $sideMenus
        ];
    }


    /**
     * Getting the mainApp data
     */
    public static function appConfigData()
    {
        // builder
        $builder = Config::where('isActive', '1');
        // Cache
        return Cache::remember('config', 50000, function () use ($builder) {
            return [
                "title" => $builder->where('configName', 'Project')->first()->configDescription,
                "footer" => Config::find(3)->configDescription
            ];
        });
    }

    /**
     * Summary of Brand And Store
     * @return array
     */
    public function brandAndStore()
    {
        // Getting the Brand List

        $brands = Cache::remember('store-main-list-brand-name', 50000, function () {
            return DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
                'storeId' => auth()->user()->storeUID,
                'userId' => auth()->user()->userUID,
                'roleId' => auth()->user()->roleUID,
                'procType' => 'brands'
            ]);
        });

        $store = Cache::remember('store-main-list-location', 50000, function () {
            return DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
                'storeId' => auth()->user()->storeUID,
                'userId' => auth()->user()->userUID,
                'roleId' => auth()->user()->roleUID,
                'procType' => 'stores'
            ]);
        });



        return [
            'brandList' => $brands,
            'storeList' => $store
        ];
    }


    public static function getStoreIDUsingRetekCodeForICICI(string|null $retekCode): string|null
    {

        $sapCode = "";

        $sapselect = Store::select('Store ID')->where('RETEK Code', '=', $retekCode)->get();
        $sapCount = $sapselect->count();

        if ($sapCount > 0) {
            $sapCode = $sapselect->toArray()[0]['Store ID'];
        }

        return $sapCode;
    }

    public static function getReteckCodeUsingTIDForICICI(string|null $mid, string|null $transactionDt): array
    {

        $main_ = [
            "retekCode" => null,
            "storeID" => null,
            "brand" => null
        ];

        $data_ = ($mid && $transactionDt) ? MICICIMID::select('storeID', 'brandCode', 'newRetekCode', 'oldRetekCode', 'conversionDt')
            ->where('MID', '=', $mid)
            ->where('closureDate', '=', null)
            ->where('isActive', 1)
            ->first() : null;
        if ($data_) {
            if (!self::isGreaterThan(date: $transactionDt, dateToCompare: $data_->conversionDt)) {
                $main_["retekCode"] = !($data_->oldRetekCode) ? $data_->newRetekCode : $data_->oldRetekCode;
                $main_["storeID"] = $data_->storeID;
                $main_["brand"] = $data_->brandCode;
            } else {
                $main_["retekCode"] = $data_->newRetekCode;
                $main_["storeID"] = $data_->storeID;
                $main_["brand"] = $data_->brandCode;
            }
        }
        
        // dd($main_);
        return $main_;
    }






    public static function isnull(float $number, $replacement)
    {
        return isset($number) ? $number : $replacement;
    }
}
