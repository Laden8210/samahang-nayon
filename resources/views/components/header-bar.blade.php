<nav class="flex drop-shadow h-auto bg-white p-3 justify-end z-50">
    <div class="grid grid-cols-2 gap-2 items-center px-2 my-1 ">

        <div class="relative">
            <button data-dropdown-toggle="notificationDropdown" data-dropdown-delay="500"
                class="rounded-full w-6 h-6 overflow-hidden align-middle items-center mx-1">
                <i class="far fa-bell mx-1 text-slate-500"></i>
            </button>
            @if ($unreadCount > 0)
                <span class="absolute left-4 rounded-full bg-red-700 px-1.5 text-white font-semibold"
                    style="font-size: 10px">{{ $unreadCount }}</span>
            @endif
        </div>

        <!-- Notifications dropdown -->
        <div id="notificationDropdown"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg drop-shadow-sm w-52 dark:bg-gray-700 p-1">
            @forelse ($notifications as $notification)
                <div class="p-2 rounded-lg hover:bg-slate-100">
                    <p class="text-xs font-semibold truncate">{{ $notification->title }}</p>
                    <p class="text-xs">{{ $notification->message }}</p>
                    <span class="text-xs text-slate-500">{{ $notification->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <div class="p-2 rounded-lg">
                    <p class="text-xs text-center text-gray-500">No new notifications</p>
                </div>
            @endforelse
        </div>

        <button class="rounded-full bg-slate-500 w-6 h-6 overflow-hidden align-middle items-center mx-1"
            id="dropdownDelayButton" data-dropdown-toggle="dropdownDelay" data-dropdown-delay="500"
            data-dropdown-trigger="hover">
            <img src="{{ asset('img/logo.jpg') }}" class="w-6">
        </button>
        <div id="dropdownDelay"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 max-h-96 overflow-auto">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDelayButton">
                <li class="flex justify-normal items-center gap-2 w-full">
                    <a href="{{ route('logout') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">
                        <i class="fas fa-sign-out-alt"></i> Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
