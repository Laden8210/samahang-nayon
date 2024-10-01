<div>


    <div class="justify-between flex p-1">
        <h1 class="text-2xl font-bold p-2">Report</h1>
        <div class="p-2">
            <button class="bg-cyan-400 font-medium text-white px-2 py-1 rounded " x-data
                x-on:click="$dispatch('open-modal', {name: 'generate-report-modal'})"> Create
                Report
            </button>




        </div>
    </div>
    <div>
        <x-modal title="Generate Report" name="generate-report-modal">

            @slot('body')
                <form wire:submit.prevent="createReport">
                    <div class="grid grid-cols-2">

                        <div class="col-span-2">
                            <x-combobox name="type" model="type" placeholder="Select Report Type"
                            :options="['Daily Revenue Report', 'Weekly Revenue Report', 'Monthly Revenue Report', 'Reservation Report', 'Arrival and Departure Report', 'Cancellation Report', 'Guest History Report']" />
                            @error('type')
                                <p class="text-red-500 text-xs italic mt-1"><i
                                        class="fas fa-exclamation-circle"></i></i>{{ $message }}
                                </p>
                            @enderror
                        </div>




                        <div class="col-span-2">
                            <x-text-field1 type="date" name="startdate" placeholder="Start Date" model="startdate"
                                label="Start Date" />
                            @error('startdate')
                                <p class="text-red-500 text-xs italic mt-1"><i
                                        class="fas fa-exclamation-circle"></i></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <x-text-field1 type="date" name="enddate" placeholder="End Date" model="enddate"
                                label="End Date" />
                            @error('enddate')
                                <p class="text-red-500 text-xs italic mt-1"><i
                                        class="fas fa-exclamation-circle"></i></i>{{ $message }}
                                </p>
                            @enderror

                        </div>
                    </div>

                    <button class="w-full bg-cyan-900 text-white py-2 rounded mt-4" type="submit">Create Report</button>
                </form>
            @endslot
        </x-modal>

        <div class="bg-gray-50 rounded">


            <h5 class="mx-2 font-bold px-2 pt-2">Promotion</h5>
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

                            <th class="py-2">Report</th>
                            <th class="py-2">Generate By</th>
                            <th class="py-2">Date</th>
                            <th class="py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($reports as $report)
                            <tr class="text-center">
                                <td class="py-2">{{ $report->ReportName }}</td>
                                <td class="py-2">
                                    {{ $report->employee->FirstName . ' ' . $report->employee->LastName }}
                                </td>
                                <td class="py-2">{{ $report->CreatedAt }}</td>
                                <td class="py-2 flex justify-center gap-2">
                                    <a class="bg-cyan-400 font-medium text-white px-2 py-1 rounded"
                                        href="{{ route('download-report', $report->ReportId) }}" download>
                                        Download
                                    </a>

                                    <a class="bg-red-400 font-medium text-white px-2 py-1 rounded"
                                        href="{{ route('download-report', $report->ReportId) }}" target="_blank">
                                        View
                                    </a>
                                </td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>


        </div>
    </div>
