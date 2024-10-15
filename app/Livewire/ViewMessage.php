<?php

namespace App\Livewire;

use App\Models\Guest;
use Livewire\Component;
use App\Models\Message;

class ViewMessage extends Component
{

    public $selectedGuest;
    public $message;

    public $search;

    public function render()
    {
        return view('livewire.view-message', [
            "guests" => Guest::whereHas('messages')
                ->with(['messages' => function ($query) {
                    $query->orderBy('DateSent', 'desc')->orderBy('TimeSent', 'desc'); // Sort by DateSent and TimeSent
                }])->search($this->search)
                ->get(),
        ]);
    }


    public function selectGuest($id)
    {
        $this->selectedGuest = Guest::find($id);
    }

    public function sendMessage(){

        if($this->selectedGuest == null){
            return;
        }
        $message = new Message();
        $message->GuestId = $this->selectedGuest->GuestId;

        $message->IsReadEmployee = false;
        $message->IsReadGuest = false;
        $message->Message = $this->message;
        $message->isGuestMessage = false;
        $message->DateSent = now()->toDateString();
        $message->TimeSent = now()->toTimeString();
        $message->save();

        $this->message = "";
    }


}
