@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
    <div class="w-full h-screen shadow rounded overflow-hidden">
        <div class="grid grid-cols-12 h-full">

            <!-- Sidebar: Contact List -->
            <div class="col-span-3 bg-gray-100 p-4 border-r border-gray-300">
                <!-- Search bar -->
                <div class="flex justify-between items-center mb-4 gap-2">
                    <input type="text" class="w-10/12 p-2 border border-gray-300 rounded" placeholder="Search">
                    <button class="bg-blue-500 text-white p-2 rounded">Search</button>
                </div>

                <div class="text-xl font-semibold mb-2">
                    All Messages
                </div>

                <!-- Contacts List -->
                <div class="space-y-4">
                    <div class="p-2 bg-white rounded shadow-sm cursor-pointer hover:bg-gray-200">
                        <div  class="flex justify-between items-start">
                            <h3 class="font-bold">Romy Murray</h3>
                            <span>2:00 pm</span>
                        </div>

                        <p class="text-sm text-gray-500">Active now</p>
                    </div>
                    <!-- Add more contact entries here -->
                </div>
            </div>

            <!-- Chat Area -->
            <div class="col-span-9 relative bg-white">

                <!-- Chat Header -->
                <div class="p-4 bg-cyan-100 border-b border-gray-300">
                    <h1 class="text-2xl font-bold">Romy Murray</h1>
                    <p class="text-sm text-gray-500">Active Now</p>
                </div>

                <!-- Message Area -->
                <div class="h-full overflow-y-auto p-4" style="height: calc(100vh - 150px);">
                    <!-- Messages will go here -->
                    <div class="mb-4">
                        <div class="bg-gray-200 p-2 rounded-lg inline-block">
                            <p>Hello! How are you?</p>
                        </div>
                    </div>
                    <div class="mb-4 text-right">
                        <div class="bg-blue-500 text-white p-2 rounded-lg inline-block">
                            <p>I'm doing well, thank you!</p>
                        </div>
                    </div>
                    <!-- Add more messages here -->
                </div>

                <!-- Message Input Area -->
                <div class="absolute bottom-0 w-full bg-gray-100 border-t border-gray-300 p-4">
                    <div class="flex items-center space-x-2">
                        <textarea class="w-full p-2 border border-gray-300 rounded-lg resize-none" rows="2" placeholder="Type your message..."></textarea>
                        <button class="bg-blue-500 text-white p-3 rounded-lg">Send</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
