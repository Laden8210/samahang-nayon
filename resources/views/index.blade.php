<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">
</head>

<body>
    <nav class="flex drop-shadow h-auto bg-white p-2 justify-between">
        <div class="flex justify-normal items-center">
            <img src="{{ asset('img/logo.jpg') }}" class="mx-2 w-10">
            Samahang Nayon
        </div>

        <div class="flex justify-normal items-center px-2">
            <i class="fa-solid fa-globe mx-2"></i>
            <i class="fa-solid fa-circle-question"></i>
        </div>
    </nav>

    <main class="p-2 flex justify-center items-center h-screen">
        <div class="flex flex-col justify-center items-center w-1/2">
            <img src="{{ asset('img/logo.jpg') }}" class="h-80 max-w-none">
        </div>

        <div class="flex flex-col justify-center items-center w-2/3">

            <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
                <h1 class="text-2xl font-bold mb-2">Welcome back</h1>
                <p class="text-gray-400 mb-20">Login to your account</p>
                <div class="relative mb-4">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </span>
                    <input type="text"
                        class="bg-gray-100 text-gray-900 placeholder-gray-400 px-3 py-2 pl-10 rounded-lg w-full focus:outline-none"
                        placeholder="What is your email?">
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-lock text-gray-400"></i>
                    </span>
                    <input type="password"
                        class="bg-gray-100 text-gray-900 placeholder-gray-400 px-3 py-2 pl-10 rounded-lg w-full focus:outline-none"
                        placeholder="Enter your password">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i class="fas fa-eye text-gray-400"></i>
                    </span>
                </div>


                <div class="flex justify-between items-center mb-6 py-2 ">
                    <div class="items-center flex"><input type="checkbox" name="" id=""
                            class="mx-1 mt-1">
                        <p>Remember me</p>
                    </div>
                    <div><a href="#" class="text-cyan-400">Forgot password?</a></div>
                </div>

                <button class="bg-cyan-400 text-white px-4 py-2 rounded-lg w-full hover:bg-cyan-500 hover:text-gray-100">Continue</button>

            </div>

        </div>
    </main>

</body>

</html>
