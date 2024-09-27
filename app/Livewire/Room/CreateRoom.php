<?php

namespace App\Livewire\Room;


use Livewire\Component;
use App\Models\Room;
use Livewire\WithFileUploads;
use App\Models\RoomPictures;

class CreateRoom extends Component
{
    use WithFileUploads;
    public $rate;
    public $roomNumber;
    public $roomType;
    public $capacity;
    public $description;
    public $pictures = [];

    public function render()
    {
        return view('livewire.room.create-room');
    }

    public function createRoom()
    {
        $this->validate(
            [
                'rate' => 'required',
                'roomNumber' => 'required|numeric|unique:rooms,RoomNumber',
                'roomType' => 'required',
                'capacity' => 'required',
                'description' => 'required',
            ],
            [
                'rate.required' => 'The room rate field is required.',
                'roomNumber.required' => 'The room number field is required.',
                'roomType.required' => 'The room type field is required.',
                'capacity.required' => 'The capacity field is required.',
                'description.required' => 'The description field is required.',
                'roomNumber.numeric' => 'The room number field must be numeric.',
            ]

        );

        $room = new Room();
        $room->RoomPrice = $this->rate;
        $room->RoomNumber = $this->roomNumber;
        $room->RoomType = $this->roomType;
        $room->Capacity = $this->capacity;
        $room->Description = $this->description;

        $room->Status = 'Available';
        $room->save();
        foreach ($this->pictures as $picture) {
            $room->roomPictures()->create([
                'PictureFile' => file_get_contents($picture->getRealPath()),
            ]);
        }




        session()->flash('message', 'Room created successfully.');

        $this->rate = '';
        $this->roomNumber = '';
        $this->roomType = '';
        $this->capacity = '';
        $this->description = '';

        sleep(1);
        return redirect()->route('rooms');
    }

    public function removePicture($index)
    {
        array_splice($this->pictures, $index, 1);
    }
}
