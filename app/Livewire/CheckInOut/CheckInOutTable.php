<?php

namespace App\Livewire\CheckInOut;

use Livewire\Component;
use App\Models\CheckInOut;

class CheckInOutTable extends Component
{
    public function render()
    {
        return view('livewire.check-in-out.check-in-out-table',
            [
                'checkInOuts' => CheckInOut::with('reservation', 'guest')->get()
            ]
    );
    }
}
