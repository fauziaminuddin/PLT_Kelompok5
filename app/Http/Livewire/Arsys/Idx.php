<?php

namespace App\Http\Livewire\Arsys;

use Livewire\Component;
use Auth;
use App\Models\User;

class Idx extends Component
{
    public function mount()
    {
        $user = User::where('sso_username', cas()->user())->first();
        Auth::login($user);
        return redirect()->route('arsys.user.profile.create');
        //return view('livewire.index');
    }
}
