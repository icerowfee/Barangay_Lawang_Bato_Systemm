<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>

<body class="min-h-screen flex flex-col bg-white"> <!-- full light blue background -->

    <header class="bg-[#0F3860] text-white shadow-lg h-24 w-full flex items-center z-50">
        <nav class="container mx-auto flex justify-between items-center py-4 px-6">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <div class="flex items-center space-x-2 mr-4">
                    <img class="w-14" src="{{ asset('images/valenzuela-logo.png') }}" alt="Valenzuela Logo">
                    <img class="w-14" src="{{ asset('images/lawang-bato-logo.png') }}" alt="Lawang Bato Logo">
                </div>
                <a class="text-2xl font-bold">Barangay Lawang Bato</a>
            </div>
        </nav>
    </header>

    <!-- Right Login Form -->
    <div class="flex-1 flex items-center justify-center px-8">
        <div class="w-full max-w-md text-center">
            <img src="{{ asset('images/lawang-bato-logo.png') }}" alt="Logo" class="mx-auto h-24 mb-4">
            <h2 class="text-xl font-bold text-gray-800">Log In</h2>
            <p class="text-gray-600 mb-6">Log in to Company Dashboard</p>

            <form action="{{ route('company.login') }}" method="POST" class="space-y-4">
                @csrf
                <input type="email" name="account_email" placeholder="Email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="password" name="password" placeholder="Password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit"
                    class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition">Login</button>
            </form>

            <div class="mt-6 text-gray-600">
                Don't have an account?
                <a href="/company-account-registration" class="text-blue-600 hover:underline">Register here</a>
            </div>
        </div>
    </div>

    @livewireScripts
    
</body>

</html>
