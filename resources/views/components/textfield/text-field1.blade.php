
<div class="mt-1">
    <label class="text-slate-500 fs-4 px-1">{{$label}} </label>
    <input type="text" wire:model="{{ $model}}" name="{{$type}}"
        class="mt-1 block w-full px-3 py-2 border border-gray-300  shadow-sm focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm"
        placeholder="{{$placeholder}}">
</div>
