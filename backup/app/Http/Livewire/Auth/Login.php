<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Validator;

class Login extends Component {

    public $email;
    public $password;
    public $remember;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
        'remember' => 'nullable',
    ];

    protected $messages = [
        'email.required' => 'The Email Address cannot be empty.',
        'email.email' => 'The Email Address format is not valid.',
    ];


    public function mount() {
        Cache::forget('menus');

        Artisan::call('cache:clear');

        if (Auth::check() && auth()->user()->roleUID == '1')
            return redirect(RouteServiceProvider::ADMIN);

        // Area Manager
        if (Auth::check() && auth()->user()->roleUID == '4')
            return redirect(RouteServiceProvider::AREAMANAGER);

        // Commertial Head
        if (Auth::check() && auth()->user()->roleUID == '2')
            return redirect(RouteServiceProvider::COMMERTIALHEAD);

        // Commertial Team
        if (Auth::check() && auth()->user()->roleUID == '3')
            return redirect(RouteServiceProvider::COMMERTIALTEAM);

        // Store User
        if (Auth::check() && auth()->user()->roleUID == '5')
            return redirect(RouteServiceProvider::STOREUSER);
    }


    public function authenticate($request) {

        // clearing cache for new logins
        Cache::forget('menus');
        Artisan::call('cache:clear');


        $this->email = $request['email'];
        $this->password = $request['password'];
        $this->remember = $request['remember'];


        $pre_auth = User::where('email', $this->email)?->first();

        if ($pre_auth && $pre_auth->isActive != '1') {
            $this->addError('error', 'This Account is not active, Please check with your commercial');
            return false;
        }


        if (Auth::guard('web')->attempt(['email' => $this->email, 'password' => $this->password])) {

            \Illuminate\Support\Facades\Session::regenerate();

            if (auth()->user()->roleUID == '1')
                return redirect(RouteServiceProvider::ADMIN);

            // Area Manager
            if (auth()->user()->roleUID == '4')
                return redirect(RouteServiceProvider::AREAMANAGER);

            // Commertial Head
            if (auth()->user()->roleUID == '2')
                return redirect(RouteServiceProvider::COMMERTIALHEAD);

            // Commertial Team
            if (auth()->user()->roleUID == '3')
                return redirect(RouteServiceProvider::COMMERTIALTEAM);

            // Store User
            if (auth()->user()->roleUID == '5')
                return redirect(RouteServiceProvider::STOREUSER);
            // If doesnt match the default case
            abort_if(!in_array(auth()->user()->roleUID, [1, 2, 3, 4, 5]), 401);
        }


        $this->emit('reset:login');
        $this->addError('error', 'Authentication failed!.');
        // return;
    }

    public function render() {

        Cache::forget('menus');

        Artisan::call('cache:clear');

        return view('livewire.auth.login')
            ->extends('layouts.app')
            ->section('content');
    }
}