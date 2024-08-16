<!doctype html>
<html>
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>@yield('title', 'Your App Name')</title>
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">
    @livewireStyles

</head>
<body>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-60">
            <x-sidebar />
        </div>

        <!-- Main Content Area -->
        <div class="flex flex-col flex-grow">
            <!-- Header Bar -->
            <div>
                <x-header-bar class="shadow-lg" id="mainHeader" />
            </div>

            <!-- Main Content -->
            <main class="p-2 flex-grow bg-slate-100">
                <div class="container mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
@livewireScripts
<script src="{{ asset('js/app.js') }}"></script>

</html>
