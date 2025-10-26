<header class="bg-red-800 text-white shadow-lg h-24 flex items-center z-50">
    @php
        $currentRoute = Request::path();
        $serviceRoutes = [
            'user-cedula-request',
            'user-clearance-request',
            'user-indigency-request',
        ];
        $barangayRoutes = [
            'user-about-page',
            'user-barangay-official-section',
            'user-sk-official-section',
        ];
    @endphp

    <nav class="w-11/12 mx-auto flex justify-between items-center py-4 px-6">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <div class="flex items-center space-x-2 mr-4">
                <img class="w-14" src="{{asset('images/valenzuela-logo.png')}}" alt="Valenzuela Logo">
                <img class="w-14" src="{{asset('images/lawang-bato-logo.png')}}" alt="Lawaang Bato Logo">
            </div>
            <a href="/user-home-page" class="text-2xl font-bold">Barangay Lawang Bato</a>
        </div>

        <!-- Navigation Menu -->
        <ul class="flex">
            <li><a href="/user-home-page" class="text-lg mx-1 px-4 py-2 transition-all duration-200 {{ $currentRoute === 'user-home-page' ? 'text-red-700 bg-white font-bold rounded-md' : 'hover:text-red-700 hover:bg-white font-medium hover:rounded-md' }}">Home</a></li>
            
            <!-- Sevices Dropdown -->
            <li class="relative group">
                <!-- Main "Services" link -->
                <a href="/user-cedula-request" class="text-lg mx-1 px-4 py-2 transition-all duration-200
                    {{ in_array($currentRoute, $serviceRoutes) ? 'text-red-700 bg-white font-bold rounded-md' : 'hover:text-red-700 hover:bg-white font-medium hover:rounded-md' }}">
                    Services <span class="text-sm">▼</span>
                </a>

                <!-- Dropdown Menu -->
                <ul class="absolute mt-2 left-1 w-48 bg-white text-black rounded-lg shadow-md z-40 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                    <li>
                        <a href="/user-cedula-request"
                        class="block font-medium px-4 py-2 rounded-md transition
                        {{ $currentRoute === 'user-cedula-request'
                                ? 'bg-red-100 text-black font-bold'
                                : 'hover:bg-gray-200' }}">
                            Cedula Request
                        </a>
                    </li>
                    <li>
                        <a href="/user-clearance-request"
                        class="block font-medium px-4 py-2 rounded-md transition
                        {{ $currentRoute === 'user-clearance-request'
                                ? 'bg-red-100 text-black font-bold'
                                : 'hover:bg-gray-200' }}">
                            Clearance Request
                        </a>
                    </li>
                    <li>
                        <a href="/user-indigency-request"
                        class="block font-medium px-4 py-2 rounded-md transition
                        {{ $currentRoute === 'user-indigency-request'
                                ? 'bg-red-100 text-black font-bold'
                                : 'hover:bg-gray-200' }}">
                            Indigency Request
                        </a>
                    </li>
                </ul>
            </li>

            
            <!-- Our Barangay Dropdown -->
            <li class="relative group">

                <a href="/user-about-page" class="text-lg mx-1 px-4 py-2 transition-all duration-200 {{ in_array($currentRoute, $barangayRoutes) ? 'text-red-700 bg-white font-bold rounded-md' : 'hover:text-red-700 hover:bg-white font-medium hover:rounded-md' }}">
                    Our Barangay <span class="text-sm">▼</span>
                </a>

                <!-- Dropdown Menu -->
                <ul class="absolute mt-2 left-1 w-52 bg-white text-black rounded-lg shadow-md z-40 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                    <li>
                        <a href="/user-about-page"
                        class="block font-medium px-4 py-2 rounded-md transition
                        {{ $currentRoute === 'user-about-page'
                                ? 'bg-red-100 text-black font-bold'
                                : 'hover:bg-gray-200' }}">
                            About Lawang Bato
                        </a>
                    </li>
                    <li>
                        <a href="/user-barangay-official-section"
                        class="block font-medium px-4 py-2 rounded-md transition
                        {{ $currentRoute === 'user-barangay-official-section'
                                ? 'bg-red-100 text-black font-bold'
                                : 'hover:bg-gray-200' }}">
                            Barangay Officials
                        </a>
                    </li>
                    <li>
                        <a href="/user-sk-official-section"
                        class="block font-medium px-4 py-2 rounded-md transition
                        {{ $currentRoute === 'user-sk-official-section'
                                ? 'bg-red-100 text-black font-bold'
                                : 'hover:bg-gray-200' }}">
                            SK Officials
                        </a>
                    </li>
                </ul>
            </li>

            <li><a href="/user-job-seeking" class="text-lg mx-1 px-4 py-2 transition-all duration-200 {{ $currentRoute === 'user-job-seeking' ? 'text-red-700 bg-white font-bold rounded-md' : 'hover:text-red-700 hover:bg-white font-medium hover:rounded-md' }}">Job Referral</a></li>
            
            <li><a href="/user-contact-us-page" class="text-lg mx-1 px-4 py-2 transition-all duration-200 {{ $currentRoute === 'user-contact-us-page' ? 'text-red-700 bg-white font-bold rounded-md' : 'hover:text-red-700 hover:bg-white font-medium hover:rounded-md' }}">Contact</a></li>

            {{-- @if (auth()->user()?->status == 'Active') --}}
                {{-- <li><a href="/user-account-management" class="hover:underline">Account</a></li> --}}
                {{-- <li>
                    <form method="POST" action="{{ route('user.logout') }}">
                        @csrf
                        <button type="submit" class="hover:underline bg-transparent border-none text-left cursor-pointer">
                            Logout
                        </button>
                    </form>
                </li> --}}
            {{-- @endif --}}
        </ul>
    </nav>
</header>