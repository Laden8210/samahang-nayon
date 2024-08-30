<div class="bg-gray-50 rounded">
    <h5 class="mx-2 font-bold px-2 pt-2">Search</h5>
    <div class="relative mb-4 w-1/3 mx-3">

        <input type="text" wire:model.live.debounce.300ms = "search"
            class="bg-gray-100 text-gray-900 placeholder-gray-400 px-3 py-2  rounded-lg w-full outline-none focus:outline-none"
            placeholder="Search . . . ">
        <span class="absolute inset-y-0 right-0 flex items-center pr-3">
            <i class="fas fa-search text-gray-400"></i>
        </span>
    </div>

    <div class="w-full flex p-2 justify-center">
        <table class="w-full text-sm text-left rtl:text-right overflow-hidden">
            <thead class="text-xs uppercase bg-gray-100 ">
                <tr class="text-center">
                    <th class="py-2">Transaction Id</th>
                    <th class="py-2">Payeer Name</th>
                    <th class="py-2">Purpose</th>
                    <th class="py-2">Date</th>
                    <th class="py-2">Payment Method</th>
                    <th class="py-2">Amount</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr class="text-center">
                        <td class="py-2">{{ $payment->ReferenceNumber }}</td>
                        <td class="py-2">{{ $payment->guest->FirstName }}</td>
                        <td class="py-2">{{ $payment->Purpose }}</td>
                        <td class="py-2">{{ $payment->DateCreated }}</td>
                        <td class="py-2">{{ $payment->PaymentType }}</td>
                        <td class="py-2">{{ $payment->AmountPaid }}</td>
                        <td class="py-2">{{ $payment->Status }}</td>
                        <td class="py-2">
                            <div class="flex justify-center">

                                <a href="{{ route('receipt', ['view' => Crypt::encrypt($payment->ReferenceNumber)]) }}" target="_blank"
                                    class="rounded-full hover:bg-blue-400 px-2 py-1 hover:text-white">
                                    <i class="fas fa-print"></i>
                                </a>


                                <button
                                type="button"
                                    x-data
                                    x-click="paymentDetailsModal = true"
                                    wire:click="selectPayments({{ $payment->PaymentId }})"
                                    class="rounded-full hover:bg-green-400 px-2 py-1 hover:text-white"><i
                                        class="fas fa-eye"></i></button>

                            </div>

                        </td>
                    </tr>
                @endforeach
            <tbody>

        </table>


    </div>


    <x-modal name="payment-details-modal" title="Payment Detals">
        @slot('body')
            <div class="p-4 md:p-5 text-center">
                <div class="grid grid-cols-3">
                    <div class="text-start font-bold">
                        <p class="text-sm ">Transaction Id</p>
                        <p class="text-sm ">Payeer Name</p>
                        <p class="text-sm ">Purpose</p>
                        <p class="text-sm ">Date</p>
                        <p class="text-sm ">Payment Method</p>
                        <p class="text-sm ">Amount</p>
                        <p class="text-sm ">Status</p>
                    </div>
                    <div class="col-span-2 text-start">
                        @if ($selectPayment)
                            <p class="text-sm font-semibold">{{ $selectPayment->ReferenceNumber }}</p>
                            <p class="text-sm font-semibold">
                                {{ $selectPayment->guest->FirstName . ' ' . $selectPayment->guest->MiddleName[0] . '. ' . $selectPayment->guest->LastName }}
                            </p>
                            <p class="text-sm font-semibold">{{ $selectPayment->Purpose }}</p>
                            <p class="text-sm font-semibold">{{ $selectPayment->DateCreated }}</p>
                            <p class="text-sm font-semibold">{{ $selectPayment->PaymentType }}</p>
                            <p class="text-sm font-semibold">{{ $selectPayment->AmountPaid }}</p>
                            <p class="text-sm font-semibold">{{ $selectPayment->Status }}</p>
                        @endif

                    </div>
                </div>
            </div>
        @endslot
    </x-modal>

</div>
