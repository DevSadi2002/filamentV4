<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Reset Password')]
class ResetPasswordPage extends Component  // اسم الكلاس صُحح
{
    public $token = '';
    public $email = '';  // قيمة افتراضية
    public $password = '';
    public $password_confirmation = '';

    public function mount($token)
    {
        $this->token = $token;
        // جلب الإيميل من الطلب إذا موجود
        $this->email = request('email');
    }

    public function save()
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $status = Password::reset([
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token
        ], function (User $user, string $password) {  // string بحرف صغير
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();
            event(new PasswordReset($user));
        });

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('message', 'Password reset successfully!');
            return redirect('/login');
        }

        session()->flash('error', 'Something went wrong. Please try again.');
    }
    public function render()
    {
        return view('livewire.auth.rest-password-page');
    }
}
