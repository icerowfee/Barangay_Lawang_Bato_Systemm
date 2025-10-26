<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body class="min-h-screen flex bg-[#e0f2fe]"> <!-- full light blue background -->

    <!-- Left Blue Curve -->
    <div class="w-1/2 relative ">
        <div class="absolute -left-[50%]  -top-[25%] w-[150%] h-[150%] bg-[#90b8d1] rounded-r-full"></div>
    </div>

    <!-- Right Login Form -->
    <div class="w-1/2 flex items-center justify-center px-8">
        <div class="w-full max-w-md text-center">
            <img src="{{ asset('images/lawang-bato-logo.png') }}" alt="Logo" class="mx-auto h-24 mb-4">
            <h2 class="text-xl font-bold text-gray-800">Log In</h2>
            <p class="text-gray-600 mb-6">Log in to Admin Dashboard</p>

            <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
                @csrf
                <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="password" name="password" placeholder="Password (FL-YY-MM-DD)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit" class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition">Login</button>
            </form>
        </div>
    </div>

    @livewireScripts

</body>
</html>