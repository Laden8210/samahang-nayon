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
        $selectedPromotion = Promotion::find($promotionId);

        $this->promotionName = $selectedPromotion->promotion;
        $this->description = $selectedPromotion->description;
        $this->discount = $selectedPromotion->discount;
        $this->startingDate = $selectedPromotion->startingDate;
        $this->endDate = $selectedPromotion->endDate;
    }

    public function deletePromotion($promotionId)
    {
        Promotion::destroy($promotionId);
        session()->flash('message', 'Promotion deleted successfully.');
    }





}
