<?php

namespace App\Livewire\Payment;

use Livewire\Component;
use App\Models\Payment;

class PaymentTable extends Component
{
    public $search = '';
    public $selectPayment;

    public function render()
    {
        return view('livewire.payment.payment-table',
        [
            'payments' => Payment::search($this->search)->paginate(100)
        ]);
    }

    public function selectPayments($paymentId){
        $this->selectPayment = Payment::find($paymentId);
        $this->dispatch('open-modal', name: 'payment-details-modal');
    }

}
