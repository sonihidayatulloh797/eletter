<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Component
{
    public $email;
    public $password;
    public $confirm_password;

    public function resetPassword()
    {
        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->addError('email', 'Email tidak ditemukan.');
            return;
        }

        if ($this->password !== $this->confirm_password) {
            $this->addError('confirm_password', 'Password tidak sama.');
            return;
        }

        $user->password = Hash::make($this->password);
        $user->save();

        session()->flash('success', 'Password berhasil diubah. Silakan login kembali.');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.reset-password')->layout('layouts.guest');
    }
}
