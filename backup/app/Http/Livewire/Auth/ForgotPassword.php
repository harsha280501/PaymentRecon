<?php
namespace App\Http\Livewire\Auth;



use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


class ForgotPassword extends Component {

    public $email;

    public function sendResetLink($data) {

        $userExists = User::where('email', $data['email'])->exists();

        if ($userExists) {
            $token = Str::random(60);
            $this->callSendPasswordResetEmailProcedure($data['email'], $token);
            session()->flash('message', 'Password Reset Link has been sent successfully.');
            return redirect()->route('login')->with('reset:password', 'Password Reset Link Sent to Mail');
        } else {
            $this->addError('email', 'Invalid email address');
            return;
        }
    }




    private function callSendPasswordResetEmailProcedure($email, $token) {

        try {
            DB::statement('PaymentMIS_PROC_AUTH_EMAIL_RESET_PASSWORD :email, :token, :url', [
                'email' => $email,
                'token' => $token,
                'url' => url('/')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function render() {
        return view('livewire.auth.forgot-password')
            ->extends('layouts.app')
            ->section('content');
    }
}