<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Profile extends Component
{
    public $name;
    public $email;
    public $password;
    public $new_password;
    public $confirm_password;

    // 🆕 Step wizard (1 = Profile, 2 = Password)
    public $currentStep = 1;

    // Modal lama masih disimpan (tidak dihapus)
    public $showPasswordModal = false;

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        session()->flash('message', 'Profil berhasil diperbarui!');
    }

    public function updatePassword()
    {
        $user = Auth::user();

        if (!Hash::check($this->password, $user->password)) {
            $this->addError('password', 'Password lama tidak sesuai.');
            return;
        }

        if ($this->new_password !== $this->confirm_password) {
            $this->addError('confirm_password', 'Konfirmasi password tidak sama.');
            return;
        }

        $user->password = Hash::make($this->new_password);
        $user->save();

        $this->reset(['password', 'new_password', 'confirm_password']);
        $this->showPasswordModal = false;

        session()->flash('message', 'Password berhasil diperbarui!');
    }

    // 🆕 Navigasi antar step
    public function nextStep()
    {
        if ($this->currentStep < 2) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function render()
    {
        return view('livewire.profile.profile');
    }
}
