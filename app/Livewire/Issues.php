<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Issue;
use Auth;

class Issues extends Component
{
    public $issues;

    public function mount()
    {
        $this->issues = Issue::where('user_id', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.issues');
    }
}
