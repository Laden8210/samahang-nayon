<?php

namespace App\Livewire\Promotion;

use App\Livewire\Room\UpdateRoom;
use App\Models\DiscountedRoom;
use Livewire\Component;
use App\Models\Promotion;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class PromotionTable extends Component
{

    public $search;
    public $promotionName;
    public $description;
    public $discount;
    public $startingDate;
    public $endDate;
    public $selectedPromotion;
    public $selectRoom  = [];

    public $updateSelectRoom = [];
    public $updateRoom;

    public $discountedrooms;

    public function render()
    {
        $rooms = Room::select('RoomType', DB::raw('COUNT(*) as total_rooms'))
            ->groupBy('RoomType')
            ->get();
        return view(
            'livewire.promotion.promotion-table',
            [
                'promotions' => Promotion::search($this->search)->get(),
                'rooms' => $rooms,
            ]
        );
    }

    public function addPromotion()
    {


        $this->validate([
            'promotionName' => 'required',
            'description' => 'required',
            'discount' => 'required',
            'startingDate' => 'required',
            'endDate' => 'required',
        ]);

        $promotion = new Promotion();
        $promotion->Promotion = $this->promotionName;

        $promotion->Description = $this->description;
        $promotion->Discount = $this->discount;
        $promotion->StartDate = $this->startingDate;
        $promotion->EndDate = $this->endDate;
        $promotion->DateCreated = now();
        $promotion->save();

        $rooms = Room::whereIn('RoomType', $this->selectRoom)->get();

        foreach ($rooms as $room) {
            $promotion->discountedRooms()->create([
                'RoomId' => $room->RoomId,

            ]);
        }
        session()->flash('message', 'Promotion added successfully.');
    }


    public function updatePromotion($promotionId)
    {
        $this->selectedPromotion = Promotion::find($promotionId);

        if (!$this->selectedPromotion) {
            // Handle case where promotion is not found
            session()->flash('error', 'Promotion not found.');
            return;
        }

        $this->promotionName = $this->selectedPromotion->Promotion;
        $this->description = $this->selectedPromotion->Description;
        $this->discount = $this->selectedPromotion->Discount;
        $this->startingDate = $this->selectedPromotion->StartDate;
        $this->endDate = $this->selectedPromotion->EndDate;

        $this->updateRoom = DiscountedRoom::with('room')
            ->where('PromotionId', $this->selectedPromotion->PromotionId)
            ->get();


        $this->discountedrooms = Room::select('RoomType', DB::raw('COUNT(*) as total_rooms'))
            ->groupBy('RoomType')
            ->get();


        $this->discountedrooms = $this->discountedrooms->map(function ($room) {
            $room->isChecked = false;


            if ($this->updateRoom) {
                foreach ($this->updateRoom as $value) {
                    if ($value->room && $value->room->RoomType == $room->RoomType) {
                        $room->isChecked = true;
                        break;
                    }
                }
            }

            return $room;
        });

        $this->updateSelectRoom = $this->discountedrooms->where('isChecked', true)->pluck('RoomType')->toArray();
    }


    public function savePromotion()
    {
        $this->validate([
            'promotionName' => 'required',
            'description' => 'required',
            'discount' => 'required',
            'startingDate' => 'required',
            'endDate' => 'required',
        ]);

        // Update the selected promotion
        $this->selectedPromotion->update([
            'Promotion' => $this->promotionName,
            'Description' => $this->description,
            'Discount' => $this->discount,
            'StartDate' => $this->startingDate,
            'EndDate' => $this->endDate,
        ]);

        // Array to store the RoomIds of selected rooms
        $selectedRoomIds = [];

        foreach ($this->updateSelectRoom as $s) {
            // Get all rooms of the selected type
            $rooms = Room::where('RoomType', $s)->get();

            foreach ($rooms as $room) {
                $selectedRoomIds[] = $room->RoomId; // Collect selected RoomIds

                // Check if this discounted room already exists
                $roomExist = DiscountedRoom::where('RoomId', $room->RoomId)
                    ->where('PromotionId', $this->selectedPromotion->PromotionId)
                    ->first();

                // Create DiscountedRoom if it does not exist
                if (!$roomExist) {
                    $this->selectedPromotion->discountedRooms()->create([
                        'RoomId' => $room->RoomId,
                    ]);
                }
            }
        }

        // Delete any DiscountedRoom records that are not in the selected room IDs
        DiscountedRoom::where('PromotionId', $this->selectedPromotion->PromotionId)
            ->whereNotIn('RoomId', $selectedRoomIds)
            ->delete();

        // Dispatch close modal event and reset form
        $this->dispatch('close-modal', name: 'update-modal');
        $this->reset();

        session()->flash('message', 'Promotion updated successfully.');
    }


    public function deletePromotion($promotionId)
    {
        Promotion::destroy($promotionId);
        session()->flash('message', 'Promotion deleted successfully.');
    }
}
