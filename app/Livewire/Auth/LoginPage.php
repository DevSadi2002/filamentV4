<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class LoginPage extends Component
{
    public $email = '';
    public $password = '';

    public function save()
    {
        // التحقق من البيانات
        $validated = $this->validate([
            'email'    => 'required|email',
            'password' => 'required|min:4',
        ]);

        // محاولة تسجيل الدخول باستخدام guard web
        if (!auth('web')->attempt($validated, remember: true)) {
            session()->flash('error', 'Invalid email or password.');
            return;
        }

        // إعادة توجيه بعد نجاح تسجيل الدخول
        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
