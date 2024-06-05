<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @filamentStyles
    @livewireStyles
    @livewire('notifications')
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-50 dark:bg-gray-900">

    <div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
        <a href="/" class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
            <img src="{{asset('images/LOGO-SRS.png')}}" class="mr-4 h-11" alt="FlowBite Logo">
            <!-- <span>SSMS</span> -->
        </a>
        <!-- Card -->
        <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
            {{$slot}} <!-- Place your form content inside this div -->
        </div>
    </div>
    @filamentScripts
    @livewireScripts
</body>



</html>