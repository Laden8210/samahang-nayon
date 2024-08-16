<div>
    <form class="p-2" wire:submit.prevent="saveBooking">
        <div class="grid grid-cols-3 gap-2">

            <div class="col-span-2">
                <div class="w-full bg-slate-50 shadow rounded p-2">

                    <div class="m-4">
                        <div class="flex justify-between">
                            <h2 class="text-lg font-bold">Customer Details</h2>

                            <div>
                                <button type="button"
                                    class="bg-green-700 px-2 py-1 rounded shadow text-white">Search</button>
                            </div>
                        </div>

                        <div class="grid gap-4 mb-4 grid-cols-4">
                            <div class="col-span-2">
                                <x-textfield1 name="firstname" placeholder="First Name" model="firstname"
                                    label="First Name" />
                            </div>

                            <div class="col-span-2">
                                <x-textfield1 name="middlename" placeholder="Middle Name" model="middlename"
                                    label="Middle Name" />
                            </div>

                            <div class="col-span-2">
                                <x-textfield1 name="lastname" placeholder="Last Name" model="lastname"
                                    label="Last Name" />
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <x-textfield1 name="dob" placeholder="First Name" model="dob" type="date"
                                    label="Birthdate" />
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <x-combobox name="gender" model="gender" placeholder="Gender" :options="['Female', 'Male']" />
                            </div>

                            <div class="col-span-2">
                                <x-textfield1 name="street" placeholder="Street" model="street" label="Street" />
                            </div>

                            <div class="col-span-2">
                                <x-textfield1 name="brgy" placeholder="Brgy" model="brgy" label="Brgy" />
                            </div>

                            <div class="col-span-2">
                                <x-textfield1 name="city" placeholder="City" model="city" label="City" />
                            </div>

                            <div class="col-span-2">
                                <x-textfield1 name="province" placeholder="Povince" model="province" label="Province" />
                            </div>

                            <div class="col-span-2">
                                <x-textfield1 name="email" placeholder="Email" model="email" label="Email" />
                            </div>

                            <div class="col-span-2">
                                <x-textfield1 name="contactnumber" placeholder="Contact Number" model="contactnumber"
                                    label="Contact Number" />
                            </div>

                        </div>


                    </div>

                </div>
            </div>
            <div class="cols-span-1">
                <div class="w-full bg-slate-50 shadow rounded p-2">
                    <div class="flex justify-between px-2">
                        <h1 class="text-lg font-bold">Reservation Summary</h1>
                        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class=""
                            type="button">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </div>

                    <div class="border border-slate-200 rounded p-2 m-1">
                        <div class="grid grid-cols-2">
                            <div>
                                <p class="text-xs text-slate-700">CHECK IN</p>
                                <h2 class="text-base font-semibold text-slate-800">Sun, 22, May 2024</h2>
                            </div>
                            <div>
                                <p class="text-xs text-slate-700">CHECK OUT</p>
                                <h2 class="text-base font-semibold text-slate-800">Sun, 22, May 2024</h2>
                            </div>
                        </div>

                        <div class="text-xs mt-5">
                            <h2>TOTAL LENGHT OF STAY:</h2>
                            <span class="font-bold text-lg">3</span>
                        </div>


                        <div class="mt-5">
                            <h2 class="text-xs">YOU SELECTED</h2>
                            <h1 class="font-bold text-lg">Room Name Here</h1>
                        </div>
                    </div>

                    <div class="p-2">
                        <div class="flex justify-between pe-2 mb-2">
                            <h2 class="font-bold text-blue-950">Amenities</h2>
                            <button type="button" class=" ">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </div>

                        <div class="border border-slate-200 rounded p-2">

                            <div class="flex justify-between py-1 text-xs bg-slate-100 p-1 rounded">
                                <span>Amenities Name x 2pc</span>
                                <button class="px-1 hover:bg-slate-200 rounded-full "><i
                                        class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="flex justify-between py-1 text-xs bg-slate-100 p-1 rounded">
                                <span>Amenities Name x 2pc</span>
                                <button class="px-1 hover:bg-slate-200 rounded-full "><i
                                        class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="flex justify-between py-1 text-xs bg-slate-100 p-1 rounded">
                                <span>Amenities Name x 2pc</span>
                                <button class="px-1 hover:bg-slate-200 rounded-full "><i
                                        class="fa-solid fa-xmark"></i></button>
                            </div>

                        </div>
                    </div>

                    <div class="my-2">
                        <h2 class="font-bold">Payment Method</h2>
                        <div class="grid grid-rows-2 gap-2">
                            <div class="text-xs flex items-center gap-2">
                                <input type="radio" value="Gcash">
                                <label for="">Gcash</label>
                            </div>

                            <div class="text-xs flex items-center gap-2">
                                <input type="radio" value="Gcash">
                                <label for="">Cash</label>
                            </div>
                        </div>
                    </div>

                    <div class="my-2">
                        <h2 class="font-bold">Total Summary</h2>

                        <div class="flex justify-between text-xs">
                            <p>Room</p>
                            <p>Price</p>
                        </div>
                        <div class="flex justify-between text-xs">
                            <p>Amenities</p>
                            <p>Price</p>
                        </div>
                        <hr class="mt-1">

                        <div class="flex justify-between ">
                            <p class="font-bold text-blue-950">Total</p>
                            <p>1000</p>
                        </div>
                    </div>
                    <div class="w-full mt-5">
                        <button type="submit" class="w-full bg-cyan-900 text-white py-2 rounded">Confirm
                            Booking</button>
                    </div>
                </div>
            </div>


        </div>
    </form>
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit Booking
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">

                        <div class="col-span-2 sm:col-span-1">
                            <x-textfield1 name="firstname" placeholder="First Name" model="firstname"
                                label="Check In" />
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <x-textfield1 name="firstname" placeholder="First Name" model="firstname"
                                label="Check Out" />
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <x-textfield1 name="firstname" placeholder="Total Guest" model="firstname"
                                label="Total Guest" />
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <x-combobox name="gender" model="gender" placeholder="Room Type" :options="['Single', 'Double']" />
                        </div>

                        <div class="col-span-2 bg-slate-100 h-64 rounded overflow-auto">

                            @for ($i = 0; $i < 10; $i++)
                                <div class=" p-2 bg-white m-1 rounded shadow-sm">
                                    <div class="grid grid-cols-3">
                                        <div class="rounded overflow-auto">
                                            <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIALcAwwMBIgACEQEDEQH/xAAbAAEAAgMBAQAAAAAAAAAAAAAABAUBAgMGB//EAC4QAQACAQIEBAQGAwAAAAAAAAABAgMEEQUhMVESEyJBUmFxkSNCgaHB0TIzkv/EABcBAQEBAQAAAAAAAAAAAAAAAAABAgP/xAAWEQEBAQAAAAAAAAAAAAAAAAAAARH/2gAMAwEAAhEDEQA/APoIDo5gAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAM+G3wz9gYAAAAAAAAAAAAAAAAAAAAB202nvqL+GnKI627A548d8t4pjrNrT7QstPwusbTntvPw16fdM0+DHp6eHHH1n3l1ZtakaY8OPF/rx1r9IdN2BFa3pTJG16Vt9Y3Rc3DcF+dN8c/LnH2TAFFqNFmwbzMeKnxVR3pULV8Ppl3ti2pft7S1KzYpx0vgy0tNbY7bx8mFRoAAAAREzMREbzPtAt+F6etMUZpje9uk9oKRAjRamY38mdvnMOF6Wpaa3rNZj2mHpEfW6euowzy9dY3rP8M61iiAaZAAAZpW17xSkb2mdogHTTYL6jLFKfrPaF7hxUw44pSNoj92mk09dNiisc7TztPeXZm1qQARQAAAAAAAHmgG2AABe8PvF9Jj2/LHhn9FE7abU5NNfenOJ61npKVYv2uW8Y8dr26VjdBjiuPbnivE9o2Q9XrL6n07eGkflj+UxdRgGmQABbcM0vl0868eu0emO0InDtN5+XxWj8OnX5z2XSWtSADKgAAAAAAAAAKu3Cr/lzVn612Rs2iz4udqbx3rzXoupjzQvdRo8OfeZr4b/FVVanSZdPO9o8VPa0LqYjgKgAAAA2x0tlyVpSN7WnaGq34ZpvLx+bePXaOXyhKsSsGKuDFXHXpHWe8ugMtAAAAAAAAAAAAAABMRMbTG8ACs1nDtt76ePrT+la9Kh63Q1z73x7VyftZZUsUwzatqWmtomLR1iWGmQEjR6W2pv2pH+VgdOHaXzr+ZePw6z/ANSuWKUrjpFKRtWOkMsWtyAAAAAAAAAAAAAAAAAAAAI+r0mPUxz9N46WhXW4bqInaPDaO8SuRdTFZg4XO++e0bfDX+1lSlcdYrSsVrHSIZE1cAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAf/9k="
                                                alt="" class="w-20">
                                        </div>
                                        <div class="col-span-2">
                                            <h1>Room Name</h1>
                                            <p class="text-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                Neque mollitia vitae, quibusdam quae cum nihil doloribus, unde,
                                                distinctio in pariatur quos aut tenetur repudiandae consectetur ducimus
                                                architecto odio est ut.</p>
                                        </div>
                                    </div>
                                </div>
                            @endfor

                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Confirm
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <x-success-message-modal message="{{ session('message') }}" />
    @endif

</div>
