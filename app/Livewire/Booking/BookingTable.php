<?php

namespace App\Livewire\Booking;

use Livewire\Component;

use App\Models\Reservation;
use Livewire\WithPagination;

class BookingTable extends Component
{

    use WithPagination;

        public function updatedSearch()
    {
        // Reset pagination whenever the search term is updated
        $this->resetPage();
    }

    public $search = '';
    public function render()
    {

        return view('livewire.booking.booking-table', [
            'bookings' => Reservation::search($this->search)->orderBy('ReservationId', 'desc')->paginate(10)
        ]);
    }
}
