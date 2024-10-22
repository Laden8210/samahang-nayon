<?php

namespace App\Livewire\Room;

use Livewire\Component;
use App\Models\Room;

use Livewire\WithPagination;
class RoomTable extends Component
{
    public $search = '';
    protected $listeners = ['refreshComponent' => '$refresh'];

    use WithPagination;


    public function render()
    {
        return view('livewire.room.room-table'
        , [
            'rooms' => Room::search($this->search)->get()
        ]);
    }


    public function placeholder(){
        return view('placeholder.room');
    }

    public function delete($id)
    {
        Room::destroy($id);
        session()->flash('message', 'Room deleted.');
        $this->render();
    }

}
