<nav class="h-full shadow-lg fixed p-2 items-center align-middle w-full overflow-auto">
    <div class="flex justify-normal items-center">
        <img src="{{ asset('img/logo.jpg') }}" class="mx-2 w-10">
        <h1 class="text-2x font-bold">Samahang Nayon</h1>
    </div>


    {{-- Admin sidebar --}}
    @if (Auth::check() && Auth::user()->Position === 'System Administrator')
        <ul class="items-center pt-7">
            <x-menu-item title="Dashboard" url="{{route('dashboard')}}" icon="fas fa-home mx-2" active="true" />
        </ul>

        <hr>

        <ul class="items-center pt-3 text-gray-700">
            <li class="mb-2 font-bold ">
                Management
            </li>
            <x-menu-item title="User Account Management" url="{{ route('user') }}" icon="fas fa-home mx-2" />
            <x-menu-item title="Room Managenent" url="{{ route('rooms') }}" icon="fas fa-home mx-2" />
            <x-menu-item title="Activity Log" url="{{ route('system-log') }}" icon="fas fa-home mx-2" />

        </ul>

        <hr>
        <ul class="items-center pt-3 text-gray-700">
            <li class="mb-2 font-bold ">
                Others
            </li>

            <x-menu-item title="Setting" url="{{route('settings')}}" icon="fas fa-home mx-2" />

        </ul>
    @endif

    {{-- admin sidebar end here --}}
    {{-- Receptionist sidebar --}}
    @if (Auth::check() && Auth::user()->Position === 'Receptionist')
    <ul class="items-center pt-7">
        <x-menu-item title="Dashboard" url="{{route('dashboard')}}" icon="fas fa-home mx-2" active="true" />
    </ul>

    <ul class="items-center pt-3 text-gray-700">
        <li class="mb-2 font-bold ">
            Management
        </li>

        <x-menu-item title="Booking" url="{{ route('booking') }}" icon="fas fa-home mx-2" />
        <x-menu-item title="Room" url="{{ route('receptionistRoom') }}" icon="fas fa-home mx-2" />
        <x-menu-item title="Payment" url="{{ route('payment') }}" icon="fas fa-home mx-2" />
        <x-menu-item title="Message" url="{{ route('message') }}" icon="fas fa-home mx-2" badge="true"
            badgeCount="1" />
        <x-menu-item title="Amenities" url="{{ route('amenities') }}" icon="fas fa-home mx-2" />
        <x-menu-item title="Check-in/out" url="{{route('check-in-out')}}" icon="fas fa-home mx-2" />
        <x-menu-item title="Report" url="{{ route('report') }}" icon="fas fa-home mx-2" />

    </ul>

    <ul class="items-center pt-3 text-gray-700">
        <li class="mb-2 font-bold ">
            Other
        </li>

        <x-menu-item title="Setting" url="{{route('settings')}}" icon="fas fa-home mx-2" />
    </ul>
    @endif
    {{-- Receptionist sidebar end here --}}

    {{-- Manager sidebar --}}

    @if (Auth::check() && Auth::user()->Position === 'Manager')
    <ul class="items-center pt-7">
        <x-menu-item title="Dashboard" url="{{route('dashboard')}}" icon="fas fa-home mx-2" active="true" />
    </ul>

    <ul class="items-center pt-3 text-gray-700">
        <li class="mb-2 font-bold ">
            Management
        </li>

        <x-menu-item title="Promotions" url="{{route('promotion')}}" icon="fas fa-home mx-2" />

        <x-menu-item title="Message" url="{{ route('message') }}" icon="fas fa-home mx-2" badge="true"
            badgeCount="1" />

    </ul>

    <ul class="items-center pt-3 text-gray-700">
        <li class="mb-2 font-bold ">
            Other
        </li>

        <x-menu-item title="Setting"  url="{{ route('settings') }}" icon="fas fa-home mx-2" />
    </ul>
    @endif

</nav>
