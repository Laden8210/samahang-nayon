<?php

namespace App\Livewire\CheckInOut;

use Livewire\Component;
use App\Models\CheckInOut;
use Livewire\WithPagination;
class CheckInOutTable extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.check-in-out.check-in-out-table',
            [
                'checkInOuts' => CheckInOut::with('reservation', 'guest')->paginate(10)
            ]
    );
    }
}
