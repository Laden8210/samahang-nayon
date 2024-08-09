<nav class="w-60 h-full fixed p-2 items-center shadow align-middle overflow-x-auto">
    <div class="flex justify-normal items-center">
        <img src="{{ asset('img/logo.jpg') }}" class="mx-2 w-10">
        <h1 class="text-2x font-bold">Samahang Nayon</h1>
    </div>

    <ul class="items-center pt-7">
        <x-menu-item title="Dashboard" url="#" icon="fas fa-home mx-2" active="true" />
    </ul>

    <hr>

    <ul class="items-center pt-3 text-gray-700">
        <li class="mb-2 font-bold ">
            Management
        </li>
        <x-menu-item title="User Account Management" url="{{route('user')}}" icon="fas fa-home mx-2" />
        <x-menu-item title="Booking" url="{{route('booking')}}" icon="fas fa-home mx-2" />
        <x-menu-item title="Transaction" url="#" icon="fas fa-home mx-2" />
        <x-menu-item title="Check-in/out" url="#" icon="fas fa-home mx-2" />
        <x-menu-item title="Activity Log" url="{{route('system-log')}}" icon="fas fa-home mx-2" />
        <x-menu-item title="Room Managenent" url="{{route('rooms')}}" icon="fas fa-home mx-2" />
        <x-menu-item title="Amenities" url="{{route('amenities')}}" icon="fas fa-home mx-2" />
        <x-menu-item title="Promotion" url="{{route('promotions')}}" icon="fas fa-home mx-2" />

    </ul>

    <hr>

    <ul class="items-center pt-3 text-gray-700">
        <li class="mb-2 font-bold ">
            Others
        </li>

        <x-menu-item title="Calendar" url="#" icon="fas fa-home mx-2" badge="true" badgeCount="1" />
        <x-menu-item title="Message" url="#" icon="fas fa-home mx-2" />
        <x-menu-item title="Setting" url="#" icon="fas fa-home mx-2" />

    </ul>
</nav>
