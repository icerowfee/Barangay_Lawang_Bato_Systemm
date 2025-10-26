<!-- filepath: /c:/xampp/htdocs/Barangay_Lawang_Bato_System/resources/views/user/user-home-page.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Lawang Bato</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/lawang-bato-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/lawang-bato-logo.png') }}">
</head>
<body>
    
    <!-- Navbar -->
    @include('user/user-header')


    <!-- Hero Section -->
    <section
        class="relative bg-cover bg-center text-white py-20 h-[700px]"
        style="background-image: url('{{ asset('images/barangay-lawang-bato-3s-hero-section.jpg') }}');"
    >
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/15"></div>

        <div class="container mx-auto flex items-center justify-between relative">
            <div class="w-1/2 h-[500px] flex flex-col justify-between">
                <div>
                </div>

                <div class="flex flex-col z-50">
                    <h1 class="text-4xl font-bold">Welcome to Barangay Lawang Bato</h1>
                    <p class="mt-4">A thriving community where tradition, unity, and progress come together.</p>
                    <a href="/user-about-page" class="mt-6 bg-white text-red-800 px-6 py-3 rounded-lg font-bold w-fit hover:text-white hover:bg-red-800 transition">
                        See Our Roots
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="relative bg-[#EBF0FF] h-[150px] flex justify-center">
        <div class="w-1/5 flex flex-col justify-center text-right">
            <h1 class="text-4xl font-bold">Are you looking for a </h1>
            <a class="pt-3 text-center text-2xl hover:text-blue-700 underline transition" href="/user-job-seeking">Click Here</a>
        </div>
        <div class="w-1/5">
            <img src="{{asset('images/job-search-icon.png')}}" alt="job-search-icon" class="ml-4 absolute -top-[35px]">
        </div>

    </section>
    
    <section class="flex justify-center items-center py-24 mx-auto">
        <div class="grid grid-cols-3 w-3/5 gap-12">
            <!-- Text Section -->
            <div class="col-span-2 flex flex-col justify-center">
                <h2 class="text-3xl font-bold text-left">Our Barangay</h2>
                <p class="mt-4 text-justify">
                    Barangay Lawang Bato is a progressive and welcoming community located in the northern part of Valenzuela City. 
                    Known for its strong sense of unity, active citizen involvement, and dedication to public service, 
                    Lawang Bato continues to thrive as a model barangay that values both tradition and progress. <br><br> 
                    Visitors and residents alike will find a vibrant local culture, peaceful neighborhoods, and a committed leadership 
                    focused on inclusive development and community welfare. Whether you're here to stay or just passing through, 
                    Barangay Lawang Bato offers a glimpse into the heart of genuine Filipino hospitality and local pride.
                </p>
            </div>

            <!-- Image Section -->
            <div class="flex justify-center items-center">
                <img 
                    src="{{ asset('images/lawang-bato-logo.png') }}" 
                    alt="Lawang Bato Logo"
                    class="object-contain max-h-full h-[min(80%,400px)]"
                >
            </div>
        </div>
    </section>

    <section class="flex flex-col items-center py-24 w-full bg-[#DBEFFF] ">
        
        <h2 class="text-3xl font-bold text-left p-8 pt-0">SERVICES WE OFFER</h2>

        <div class="grid grid-cols-3 gap-12 mx-auto text-white">
            <div class="bg-[#D43F28] p-6 rounded-md shadow-xl shadow-slate-500 w-[320px] flex flex-col justify-between">
                <div class="flex flex-col justify-between">
                    <div class="flex justify-center h-[130px]">
                        
                        <img src="{{asset('images/request-clearance.png')}}" alt="">

                    </div>
                    <h3 class="text-3xl min-h-20 font-bold text-center flex items-center justify-center">Barangay Clearance</h3>
                    <p class="mt-4 text-justify px-4 text-base">A document certifying that a resident has no pending cases or issues in the barangay, often required for jobs or legal purposes.</p>
                </div>
                <div class="flex justify-center">
                    <a href="user-clearance-request" class="mt-6 bg-[#1350A0] text-white px-6 py-3 rounded-lg text-xl font-bold hover:bg-blue-900 border">Request Now!</a>
                </div>
            </div>

            <div class="bg-[#D43F28] p-6 rounded-md shadow-xl shadow-slate-500 w-[320px] flex flex-col justify-between">
                <div class="flex flex-col justify-between">
                    <div class="flex justify-center h-[130px]">
                        
                        <img src="{{asset('images/request-indigency.png')}}" alt="">

                    </div>
                    <h3 class="text-3xl min-h-20 font-bold text-center flex items-center justify-center">Barangay Indigency</h3>
                    <p class="mt-4 text-justify px-4 text-base">A certification proving a resident’s indigent status, needed for government aid, scholarships, or medical assistance.</p>
                </div>
                <div class="flex justify-center">
                    <a href="user-indigency-request" class="mt-6 bg-[#1350A0] text-white px-6 py-3 rounded-lg text-xl font-bold hover:bg-blue-900 border">Request Now!</a>
                </div>
            </div>
            
            <div class="bg-[#D43F28] p-6 rounded-md shadow-xl shadow-slate-500 w-[320px] flex flex-col justify-between">
                <div class="flex flex-col justify-between">
                    <div class="flex justify-center h-[130px]">
                        
                        <img src="{{asset('images/request-cedula.png')}}" alt="">

                    </div>
                    <h3 class="text-3xl min-h-20 font-bold text-center flex items-center justify-center">Cedula</h3>
                    <p class="mt-4 text-justify px-4 text-base">An official tax certificate used as proof of identity and residence for various legal and business transactions.</p>
                </div>
                <div class="flex justify-center">
                    <a href="user-cedula-request" class="mt-6 bg-[#1350A0] text-white px-6 py-3 rounded-lg text-xl font-bold hover:bg-blue-900 border">Request Now!</a>
                </div>
            </div>
        </div>
    </section>

    @php
      use Carbon\Carbon;   
    @endphp

    <section class="flex flex-col items-center py-24 w-full" x-data="carouselData(JSON.parse($el.dataset.announcements))" data-announcements='@json($announcements)'>
        <h2 class="text-3xl font-bold text-left p-8 pt-0">LATEST ANNOUNCEMENTS</h2>
        
        <div class="relative w-3/5 mx-auto overflow-hidden">
            @if (count($announcements) == 0)
                <div class="flex justify-center items-center h-64">
                    <p class="text-gray-500">No announcements available.</p>
                </div>
            @else
                <div class="flex transition-transform duration-500 ease-in-out"
                    :style="'transform: translateX(-' + (currentIndex * (100 / itemsPerSlide)) + '%)'">
                    @foreach ($announcements as $announcement)
                    
                    <form action="/view-announcement/{{$announcement->id}}" method="GET" 
                        class="min-w-full md:min-w-[50%] lg:min-w-[33.33%] p-4 flex justify-center ">
                        @csrf
                        <div class="flex flex-col justify-between bg-white p-6 rounded-lg shadow-lg cursor-pointer hover:shadow-xl transition h-[450px] w-full max-w-[400px]">
                            <div>
                                <img src="{{ asset('storage/' . $announcement['announcement_image']) }}" 
                                alt="Announcement Image" class="h-40 w-full object-cover rounded-t-lg mb-4">
                                <h3 class="text-xl font-semibold text-center">{{$announcement['title']}}</h3>
                                <p class="text-gray-500 text-sm text-center">
                                    {{ Carbon::parse($announcement['start_date'])->format('F d, Y') }} - 
                                    {{ Carbon::parse($announcement['end_date'])->format('F d, Y') }}
                                </p>
                                <input type="hidden" value="{{$announcement['id']}}">
                            </div>
                            <div class="flex-1 text-gray-700 overflow-y-clip">
                                <p class="line-clamp-5 text-justify">{{$announcement['body']}}</p>
                            </div>
                            
                            <div class="flex justify-center items-center mt-4">
                                <button class="bg-red-800 text-white px-6 py-2 rounded-lg">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </form>
                    @endforeach
                </div>
            @endif

            <!-- Navigation Buttons -->
            <button @click="prev()" 
                class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-2 rounded-full">
                ‹
            </button>

            <button @click="next()" 
                class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-2 rounded-full">
                ›
            </button>
        </div>  
    </section>

    <section class="relative bg-[#8B2C1D] text-white mt-[100px] pb-10">
        <!-- SVG Curve Top -->
        <div class="absolute -top-[100px] left-0 w-full overflow-hidden leading-[0]">
            <svg class="relative block w-full h-[100px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path d="M0,80 Q720,0 1440,80 L1440,100 L0,100 Z" fill="#8B2C1D"></path>
            </svg>
        </div>
        

        <!-- Section Content -->
        <div class="relative z-10 pb-12 text-center">
            <h2 class="text-3xl font-bold">Baranggay Lawang Bato Map</h2>
            <p class="mt-2">Charting Progress, Connecting Community: Navigating the Barangay Lawang Bato Master Action Plan (MAP)</p>
            
            <div class="mt-6">
                <iframe class="w-full max-w-4xl mx-auto h-80" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30870.048229391443!2d120.98156836207276!3d14.726380780413402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b17f2311be67%3A0xdbd338a857bac941!2sLawang%20Bato%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1746981805357!5m2!1sen!2sph" allowfullscreen></iframe>
            </div>
        </div>

        <div class="flex flex-col items-center">
            <div class="flex gap-4">
                <a href="/user-contact-us-page"><img class="h-[40px]" src="{{asset('images/gmail-logo.png')}}" alt=""></a>
                <a href="https://www.facebook.com/BarangayLawangBato/" target="_blank"><img class="h-[40px]" src="{{asset('images/facebook-logo.png')}}" alt=""></a>
                <a href="/user-contact-us-page"><img class="h-[40px]" src="{{asset('images/telephone-logo.png')}}" alt=""></a>
            </div>
            <p>{{Carbon::now()->format('Y')}} Barangay Lawang Bato</p>
        </div>
    </section>


    <!-- Announcement Modal -->
    <div x-cloak x-data="{ showModal: false, modalData: {} }" x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg relative">
            <button @click="showModal = false" class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded">X</button>
            <img :src="modalData.announcement_image ? '/storage/' + modalData.announcement_image : ''"
                alt="Announcement Image" class="h-48 w-full object-cover rounded-t-lg mb-4">
            <h2 class="text-2xl font-bold mb-2" x-text="modalData.title"></h2>
            <h3 class="text-md font-semibold mb-2" x-text="modalData.heading"></h3>
            <p class="text-gray-700" x-text="modalData.body"></p>
        </div>
    </div>


    <!-- Footer Section -->
    @include('user/user-footer')

    <script>
        function carouselData(announcements) {
            return {
                announcements: announcements,
                currentIndex: 0,
                itemsPerSlide: window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1,
    
                next() {
                    this.currentIndex++;
                    
                    // If we're at the end, reset to 0 (loop)
                    if (this.currentIndex >= this.announcements.length - 2) {
                        this.currentIndex = 0;
                    }
                },
    
                prev() {
                    this.currentIndex--;
                    
                    // If we're at the beginning, loop to the last item
                    if (this.currentIndex < 0) {
                        this.currentIndex = this.announcements.length - 3;
                    }
                }
            };
        }
    </script>

    @livewireScripts
    
</body>
</html>