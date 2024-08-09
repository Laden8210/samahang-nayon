<li class="mb-2 rounded p-2 {{ $active ? 'bg-cyan-100 text-cyan-500  font-medium' : '' }}  hover:bg-cyan-200">
    <a href="{{ $url }}" class="flex items-center text-xs justify-between">

        <div class="flex justify-start items-center">

            <i class="{{ $icon }} mx-2"></i>
            {{ $title }}
        </div>
        @if ($badge)
            <div class="rounded-full bg-red-600 p-1 px-2 text-xs text-white shadow">{{ $badgeCount }}</div>
        @endif
    </a>
</li>
