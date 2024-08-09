@extends('layouts.app')

@section('title', 'Promotion ')
@section('content')

<div class="justify-between flex p-1">
    <h1 class="text-2xl font-bold p-2">Promotion</h1>
    <div class="p-2">
        <a href="{{ route('addRoom') }}"
            class="bg-cyan-400 font-medium text-white px-2 py-1 rounded "> Add Promotion
        </a>

    </div>
</div>
    @livewire('promotion.promotion-table')
@endsection


