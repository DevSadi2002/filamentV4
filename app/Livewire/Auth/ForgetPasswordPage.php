<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Forget Password')]
class ForgetPasswordPage extends Component
{
    public $email = null;

    public function save()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email|max:255'
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Password reset link has been sent!');
            $this->email = '';
        } else {
            // تجنب محاولة الوصول لمصفوفة فارغة
            session()->flash('error', 'Unable to send reset link. Please check your email or try again later.');
        }
    }

    public function render()
    {
        return view('livewire.auth.forget-password-page');
    }
}
