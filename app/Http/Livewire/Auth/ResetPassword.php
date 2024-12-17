<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


class ResetPassword extends Component {

    public $token;

    public $password;

    public $password_confirmation;

    public function mount($token) {
        $this->token = $token;

        if (!DB::table('password_reset_tokens')->where('token', $this->token)->exists()) {
            abort(404);
        }
    }

    public function resetpassword() {

        $this->validate([
            'password' => 'required|min:8|confirmed'
        ]);


        if (!DB::table('password_reset_tokens')->where('token', $this->token)->exists()) {
            abort(404);
        }


        $tokenUser = DB::table('password_reset_tokens')->where('token', $this->token)->first()->email;

        // Call the stored procedure with the hashed password
        DB::statement('PaymentMIS_PROC_AUTH_RESET_PASSWORD :email, :passwd', [
            'email' => $tokenUser,
            'passwd' => Hash::make($this->password),
        ]);

        // session()->flash('message', 'Your password has been reset successfully.');
        return redirect()->route('login')->with('reset:password', 'Password Reset Successful');
    }



    public function render() {
        return view('livewire.auth.reset-password')
            ->extends('layouts.app')
            ->section('content');
    }
}