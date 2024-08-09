<div class="mt-1">

    <label class="text-slate-500 fs-4 px-1">{{$placeholder}} </label>
    <select name="{{ $name }}"
        wire:model="{{ $model }}"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm">
        <option disabled  selected>{{ $placeholder }}</option>
        @foreach($options as $option)
            <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    </select>
</div>
