<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


class ForceResetPassword extends Component {

    public $token;

    public $password;

    public $password_confirmation;



    public $message = '';


    public function mount($token) {


        if(auth()->user()->passwordUpdated) {
            return redirect()->intended('/');
        }
        
        if(auth()->user()->userUID != base64_decode($token)) {
            abort(401);
        }
    }

    public function resetpassword() {

        
        $this->validate([
            'password' => 'required|min:8|confirmed'
        ]);
        

        // Call the stored procedure with the hashed password
        $main = User::find(auth()->user()->userUID)->update([
            'password' => bcrypt($this->password),
            'passwordUpdated' => 1
        ]);

        if(!$main) {
            return $this->message = 'Something went wrong!, please try again';
        }

        return redirect()->intended('/')->with('message', 'Password Updated Successfully!');
    }



    public function render() {
        return view('livewire.auth.force-update-password')
            ->extends('layouts.app')
            ->section('content');
    }
}