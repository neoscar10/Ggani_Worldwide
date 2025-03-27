<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login Page')]
class Login extends Component
{
    public $email;
    public $password;

    public function save(){
        $this->validate([
            'email'=> 'required|max:255|email|exists:users,email',
            'password'=> 'required|min:6|max:255',
        ]);

        if (!auth()->attempt(['email' =>$this->email, 'password'=>$this->password])) {
            session()->flash('error','invalid cedentials');
            return;
        }

        //if user passes loging
        return redirect()->intended();
    }
    public function render()
    {
        return view('livewire.auth.login');
    }
}
