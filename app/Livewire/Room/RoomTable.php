<?php

namespace App\Livewire\Room;

use Livewire\Component;
use App\Models\Room;

class RoomTable extends Component
{
    public $search = '';
    protected $listeners = ['refreshComponent' => '$refresh'];


    public function render()
    {
        return view('livewire.room.room-table'
        , [
            'rooms' => Room::search($this->search)->paginate(10)
        ]);
    }


    public function delete($id)
    {
        Room::destroy($id);
        session()->flash('message', 'Room deleted.');
        $this->render();
    }

}
