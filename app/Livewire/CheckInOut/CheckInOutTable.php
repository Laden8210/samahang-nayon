<?php

namespace App\Livewire\CheckInOut;

use Livewire\Component;
use App\Models\CheckInOut;
use Livewire\WithPagination;

class CheckInOutTable extends Component
{
    use WithPagination;

    public $search = '';
    public function render()
    {
        return view('livewire.check-in-out.check-in-out-table', [
            'checkInOuts' => CheckInOut::with('reservation', 'guest')
            ->search($this->search)
                ->where('Type', 'Checked In') // Filter only check-ins
                ->orderBy('DateCreated', 'desc') // Sort by latest date
                ->orderBy('TimeCreated', 'desc') // Then by latest time
                ->paginate(10)
        ]);
    }
}
