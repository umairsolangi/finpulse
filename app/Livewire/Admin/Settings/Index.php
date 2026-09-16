<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public function mount(): void
    {
        abort_unless(auth()->check() && auth()->user()->can('settings.manage'), 403);
    }

    public function render()
    {
        return view('livewire.admin.settings.index');
    }
}
