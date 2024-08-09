<?php

namespace App\Livewire\Room;


use Livewire\Component;
use App\Models\Room;

class CreateRoom extends Component
{
    public $rate;
    public $roomNumber;
    public $roomType;
    public $capacity;
    public $description;

    public function render()
    {
        return view('livewire.room.create-room');
    }

    public function createRoom()
    {
        $this->validate([
            'rate' => 'required',
            'roomNumber' => 'required|numeric',
            'roomType' => 'required',
            'capacity' => 'required',
            'description' => 'required',
        ],[
            'rate.required' => 'The room rate field is required.',
            'roomNumber.required' => 'The room number field is required.',
            'roomType.required' => 'The room type field is required.',
            'capacity.required' => 'The capacity field is required.',
            'description.required' => 'The description field is required.',
            'roomNumber.numeric' => 'The room number field must be numeric.',
        ]

    );

        $room = new Room();
        $room->rate = $this->rate;
        $room->number = $this->roomNumber;
        $room->type = $this->roomType;
        $room->capacity = $this->capacity;
        $room->description = $this->description;
        $room->type = $this->roomType;
        $room->status = 'Available';

        $room->save();


        session()->flash('message', 'Room created successfully.');

        $this->rate = '';
        $this->roomNumber = '';
        $this->roomType = '';
        $this->capacity = '';
        $this->description = '';
    }

}
