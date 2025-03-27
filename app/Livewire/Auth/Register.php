<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Register Page - gadjo")]

class Register extends Component
{
    public $email;
    public $password;
    public $name;

    public function save(){
        // dd("user info". $this->email, $this->password, $this->name);
        $this->validate([
            "email"=> "required|email|unique:users|max:255",
            "name" => "required|max:255",
            "password"=> "required|min:6|max:255",
        ]);

        // save to db
        $user = User::create([
            "email"=> $this->email,
            "name"=> $this->name,
            "password"=> Hash::make($this->password),
        ]);

        // loging user
        auth()->login($user);
        //
        return redirect()->intended();
    }
    public function render()
    {
        return view('livewire.auth.register');
    }
}
