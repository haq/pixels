<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class ShowUser extends Component
{
    public $user;

    public function mount($name)
    {
        $this->user = User::with('videos')
            ->where('name', $name)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.show-user')
            ->extends('layouts.app');
    }
}
