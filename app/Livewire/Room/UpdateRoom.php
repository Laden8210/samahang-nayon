<?php

namespace App\Livewire\Room;

use Livewire\Component;
use App\Models\Room;
use Livewire\WithFileUploads;

class UpdateRoom extends Component
{
    use WithFileUploads;

    public $roomId;
    public $rate;
    public $roomNumber;
    public $roomType;
    public $capacity;
    public $description;
    public $pictures = [];
    public $existingPictures;
    public $room;

    public function render()
    {
        return view('livewire.room.update-room');
    }

    public function mount($roomId)
    {
        $room = Room::with('roomPictures')->find($roomId);
        $this->room = $room;
        $this->rate = $room->RoomPrice;
        $this->roomNumber = $room->RoomNumber;
        $this->roomType = $room->RoomType;
        $this->capacity = $room->Capacity;
        $this->description = $room->Description;
        $this->existingPictures = $room->roomPictures;
    }

    public function updateRoom()
    {
        $this->validate(
            [
                'rate' => 'required',
                'roomNumber' => 'required|numeric',
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

        $room = Room::find($this->roomId);
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

        session()->flash('message', 'Room updated successfully.');

        $this->rate = '';
        $this->roomNumber = '';
        $this->roomType = '';
        $this->capacity = '';
        $this->description = '';
        $this->pictures = [];

        sleep(2);
        return redirect()->route('rooms');
    }

    public function removeExistingPicture($index)
    {

        if ($this->existingPictures->has($index)) {

            $picture = $this->existingPictures[$index];
            $picture->delete();


            $this->existingPictures->forget($index);

            session()->flash('message', 'Picture removed successfully.');
        } else {
            session()->flash('error', 'Picture not found.');
        }
    }

    public function removePicture($index)
    {
        array_splice($this->pictures, $index, 1);
    }
}
