<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Announcement Details</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/lawang-bato-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/lawang-bato-logo.png') }}">
</head>
<body>

    <!-- Navbar -->
    @include('user/user-header')
    
    <div class="announcement-details my-4 p-6 max-w-4xl mx-auto bg-white rounded-xl shadow-md space-y-4">
        <h1 class="text-3xl font-bold">{{ $announcement->title }}</h1>
        <h2 class="text-xl font-semibold">{{ $announcement->heading }}</h2>
        <p class="text-gray-500">{{ $announcement->start_date }} - {{ $announcement->end_date }}</p>
        <img src="{{ asset('storage/' . $announcement['announcement_image']) }}"  alt="Announcement Picture" class="w-full h-auto rounded">
        <p class="text-lg text-justify">{!! nl2br(e($announcement->body)) !!}</p>
    </div>

    @include('user/user-footer')

    @livewireScripts
    
</body>
</html>