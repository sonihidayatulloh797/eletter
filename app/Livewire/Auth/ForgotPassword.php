<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;

class ForgotPassword extends Component
{
    public $email;

    public function sendResetLink()
    {
        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->addError('email', 'Email tidak ditemukan.');
            return;
        }

        // 👉 ieu langsung ngaredirect ke halaman reset password
        session()->flash('success', 'Email ditemukan. Silakan ubah password Anda.');
        return redirect()->route('password.reset', ['email' => $user->email]);
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('layouts.guest');
    }
}
