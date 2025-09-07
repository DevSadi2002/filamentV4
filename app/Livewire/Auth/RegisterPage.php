<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register - Hope Store')]
class RegisterPage extends Component
{
    public $name;
    public $email;
    public $password;

    public function save()
    {
        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        $user = User::create(
            [
                'name' => $this->name,
                'email' => $this->email,
                'password' => FacadesHash::make($this->password)

            ]
        );
        // login user dirceted
        auth()->login($user);
        LivewireAlert::title('Account Created!')
            ->success()
            ->show();
        return redirect()->intended('/');
    }
    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
