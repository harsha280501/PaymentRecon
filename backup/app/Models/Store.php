<?php

namespace App\Models;

use App\Http\Livewire\Admin\Sales;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model {
    use HasFactory;

    protected $table = "tbl_mStore";

    protected $primaryKey = "storeUID";

    public $timestamps = false;


    public function sapName() {
        return $this['Brand Name'] . ', ' . $this->City . ', ' . $this->Location;
    }
    public function brandName() {
        return $this['Brand Name'];
    }
    public function storeName() {
        return $this->Location;
    }


    protected $fillable = [
        "MGP SAP code",
        "Store ID",
        "RETEK Code",
        "Brand Desc",
        "StoreTypeasperBrand",
        "Channel",
        "Store Name",
        "Store opening Date",
        "SStatus",
        "Store Closing Date",
        "Location",
        "City",
        "State",
        "Address",
        "Pin code",
        "Region",
        "Store Manager Name",
        "Contact no",
        "Basement occupied (Y/No)",
        "ARM email id",
        "RM email id",
        "NROM email id",
        "RCM mail",
        "Correct store email id",
        "HO contact",
        "RD email id",
    ];
}
