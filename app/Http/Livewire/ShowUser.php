<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class ShowUser extends Component
{
    public $user;
    public $sortBy = 'desc';

    protected $rules = [
        'sortBy' => 'required|string|in:desc,asc'
    ];

    public function mount($name)
    {
        $this->user = User::where('name', $name)->firstOrFail();
    }

    public function render()
    {
        $this->validate();

        $videos = $this->user->videos()
            ->orderBy('created_at', $this->sortBy)
            ->where('converted_for_streaming_at', '<>', null)
            ->get();

        return view('livewire.show-user', [
            'videos' => $videos,
        ])->extends('layouts.app');
    }

}
