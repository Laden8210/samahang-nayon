<?php

namespace App\Livewire\Room;

use Livewire\Component;
use App\Models\Room;

class RoomTable extends Component
{
    public $search = '';
    public function render()
    {
        return view('livewire.room.room-table'
        , [
            'rooms' => Room::search($this->search)->paginate(10)
        ]);
    }

}
