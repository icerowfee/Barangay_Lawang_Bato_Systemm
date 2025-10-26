<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Our Barangay</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/lawang-bato-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/lawang-bato-logo.png') }}">
</head>
<body>

    <!-- Navbar -->
    @include('user/user-header')

    <section class="relative z-[-1]">
        <img src="{{asset('images/barangay-lawang-bato-3s-hero-section.jpg')}}" alt="Our Barangay Banner" class="w-full h-80 object-cover">
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center bg-black bg-opacity-50 ">
            <h2 class="text-7xl font-bold">Our Barangay</h2>
            <p class="text-xl mt-4">A united and thriving community built on progress, compassion, and Filipino pride.</p>
        </div>
    </section>

    <section class="grid grid-cols-3 gap-8 w-2/3 mx-auto py-20 relative">
        <div class="col-span-2 max-w-4xl">
            <h2 class="text-2xl md:text-3xl font-bold text-red-800 mb-6">History of Barangay Lawang Bato</h2>
            
            <div class="space-y-4 text-gray-800 leading-relaxed text-justify">
                <p>The history of every barangay or barrio is rooted form the narration of stories of the old people of the past. It is common that the beginning of any history happened before or during the time of the Spaniards who conquered us for almost 400 years, form the researches of the author, according to the story of the old people of the barangay, this is how the name Barangay LAWANG BATO originates;</p>
                
                <p>In the beginning, when the Spaniards conquered the Philippines and built communities or villages near the riverbanks, Pulo, a village in Valenzuela at the northern part of Manila was established as a community or town. Pulo covered a vast land consisted of Pulo, Obando, Meycauayan and Marilao. The lands in the said villages had forests, swamps and hills.</p>
                
                <p>A part of this vast land in the north-east was a thick forest and plains where wild animals like deers, boars and wild chicken or wildfowl (labuyo) usually dwelled.</p>
                
                <p>This place was commonly visited by the hunters from different town or villages. Because at that time, places had no names, the hunters made a landmark or rendezvous (meeting place) whenever they were lost in the woods.</p>
                
                <p>A lake like pond-shaped as a cauldron in the barren forest was named as “LAWANG BATO” sometime in 1800. Here, the hunters met-up, ate food and fetched drinking water from its clean and clear water especially during the month of December to April.</p>
                
                <p>Years passed, the wide forest was cleared and became a community. The marks of the villages remained and became the bases of the birth of the small villages or sheets which eventually became town and now a barangay.</p>
                
                <p>‘LAWANG BATO’ which means “LAKE ON SOLID ROCKS” (LAWA SA KAGUBATAN) in English was born in history. At first, it was consisted of seven (7) streets namely:</p>
                
                <ul class="list-disc list-inside ml-4">
                    <li><strong>Malinis Street (Sitio Malinis)</strong> – a place where grasses died during summer. The place was clean due to the thin soil on top of solid rocks.</li>
                    <li><strong>Sapang Bakaw Street (Sitio Sapang Bakaw)</strong> – a place where a portion of Camunay Creek penetrated; it became a home for many herons (Ibong Bakaw) and hunting ground for game birds.</li>
                    <li><strong>Daang Bato Street (Sitio Daang Bato)</strong> – a place where the road that passed through Barangay Lawang Bato, Meycauayan and Bulacan was made up of rocky paths.</li>
                    <li><strong>Mulawinwan Street (Sitio Mulawinwan)</strong> – a place where in that time many molave trees (kahoy na mulawin) were found.</li>
                    <li><strong>Ulingan Street (Sitio Ulingan)</strong> – a place where a wide forest served as a source of charcoal to the people for their charcoal production.</li>
                    <li><strong>Centro Street (Sitio Sentro o Gitna)</strong> – a place where the church and school were located.</li>
                    <li><strong>Punturin Street (Sitio Punturin)</strong> – a place where quarries executed by Chinese and Filipinos during the time of the Spaniards and where the “adobe” used in the historical “Wall of Intramuros” in Manila was taken, seemed to be a left-grave tomb flattened by those who founded communities in the place.</li>
                </ul>
                
                <p><strong>The 7th Street, Punturin</strong> separated from Lawang Bato and stood as a barangay in 1946 after the World War II and the Independence of the Philippines from the conquest of Japan. This is how the today’s prosperous community of BARANGAY LAWANG BATO is born.</p>
                
                <p><strong><em>“LAWA NA BATO”</em></strong> – having a lake in a rocky place which served as a landmark for the hunters (covered by Duct Property).</p>
            </div>
        </div>

        <div class="sticky top-5 flex flex-col h-min">
            <div class="flex flex-col justify-center items-center">
                <img class="object-contain max-h-full h-[min(25%,300px)]" src="{{asset('images/lawang-bato-logo.png')}}" alt="Lawang Bato Logo">
                <p class="text-center text-3xl font-bold text-blue-600 p-2">Barangay Lawang Bato</p>
            </div>

            <div class="">

            </div>
        </div>
    </section>

    <section class="flex flex-col items-center bg-[#0F3860] w-full pt-20 pb-36">
        <div class="text-center w-2/5 mb-8">
            <h1 class="text-5xl font-medium p-4 text-[#FCD116]">Our Mission</h1>
            <p class="text-white">A united, progressive, and empowered community that upholds peace, order, and sustainable development — where every resident of Lawang Bato enjoys a safe, healthy, and thriving environment.</p>
        </div>
        <div class="text-center w-2/5">
            <h1 class="text-5xl font-medium p-4 text-[#FCD116]">Our Vision</h1>
            <p class="text-white">To provide transparent, efficient, and people-centered public service through proactive governance, community participation, and continuous improvement of programs that promote the welfare and growth of every Lawang Bato resident.</p>
        </div>
    </section>


    @php
      use Carbon\Carbon;   
    @endphp


    <section class="relative bg-white pb-10">
        <!-- SVG Curve Top -->
        <div class="absolute -top-[100px] left-0 w-full overflow-hidden leading-[0]">
            <svg class="relative block w-full h-[100px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path d="M0,80 Q720,0 1440,80 L1440,100 L0,100 Z" fill="#FFFFFF"></path>
            </svg>
        </div>
        

        <!-- Section Content -->
        <div class="relative z-10 pt-10 pb-12 text-center">
            <h2 class="text-3xl font-bold text-[#0F3860]">Baranggay Lawang Bato Map</h2>
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

    @include('user/user-footer')

    @livewireScripts

</body>
</html>