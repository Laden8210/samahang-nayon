<?php

namespace App\Livewire\Promotion;

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

    public function selectPromotion($promotionId)
    {
        $selectedPromotion = Promotion::find($promotionId);
    }

    public function updatePromotion($promotionId)
    {
        $this->selectedPromotion = Promotion::find($promotionId);


        $this->promotionName = $this->selectedPromotion->Promotion;
        $this->description = $this->selectedPromotion->Description;
        $this->discount = $this->selectedPromotion->Discount;
        $this->startingDate = $this->selectedPromotion->StartDate;
        $this->endDate = $this->selectedPromotion->EndDate;
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

        $this->selectedPromotion->update([
            'Promotion' => $this->promotionName,
            'Description' => $this->description,
            'Discount' => $this->discount,
            'StartDate' => $this->startingDate,
            'EndDate' => $this->endDate,
        ]);

        $this->dispatch('close-modal', name: 'update-modal');
        session()->flash('message', 'Promotion updated successfully.');

    }

    public function deletePromotion($promotionId)
    {
        Promotion::destroy($promotionId);
        session()->flash('message', 'Promotion deleted successfully.');
    }





}
