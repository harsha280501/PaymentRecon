<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    /**
     * Table primary key
     * @var string
     */
    protected $primaryKey = 'userUID';

    /**
     * Set the Fillable to prevent mass assignment
     * @var array
     */
    protected $fillable = [
        "userUID",
        "roleUID",
        "storeUID",
        "name",
        "email",
        "email_verified_at",
        "password",
        "passwordUpdated",
        "forceResetPasswordToken",
        "remember_token",
        "isActive",
        "createdBy",
        "modifiedBy",
        "createdDate",
        "modifiedDate",
        "phase1Live",
    ];

    /**
     * Time stamps
     * @var string
     */
    const CREATED_AT = 'createdDate';

    /**
     * Time stamps
     * @var string
     */
    const UPDATED_AT = 'modifiedDate';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'forceResetPasswordToken',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'forceResetPasswordToken' => 'hashed',
    ];


    public function store() {
        $main = Arr::first(DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => $this->storeUID,
            'userId' => $this->userUID,
            'roleId' => $this->roleUID,
            'procType' => 'select-user-store'
        ]));

        if (!$main) {
            return [
                'Brand Name' => '',
                'Store Name' => '',
                'CITY' => "",
                'Location' => '',
                'Franchisee Name' => '',
                'Store Type' => '',
                'SAP' => '',
                'Store ID' => '',
            ];
        }

        return (array) $main;
    }



    public function main() {
        $main = Arr::first(DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => $this->storeUID,
            'userId' => $this->userUID,
            'roleId' => $this->roleUID,
            'procType' => 'excel-store'
        ]));

        if (!$main) {
            return [
                'Brand Name' => '',
                'Store Name' => '',
                'CITY' => "",
                'Location' => '',
                'Franchisee Name',
                'Store Type'];
        }

        return (array) $main;
    }

    public function sapName() {
        $userStore = $this->store();
        return $userStore['Brand Name'] . ', ' . $userStore["CITY"] . ', ' . $userStore["Location"];
    }
}
