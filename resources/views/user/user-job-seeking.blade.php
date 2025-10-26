<!-- filepath: c:\xampp\htdocs\Barangay_Lawang_Bato_System\resources\views\user/user-barangay-official-section.blade.php -->
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Referral</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/lawang-bato-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/lawang-bato-logo.png') }}">
</head>

<body x-data="{ showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }} }">

    {{-- Alpine.js for Toast Notification --}}

    <!-- Navbar -->
    @include('user/user-header')





    @if (auth()->user()?->status == 'Active')

        <!-- Form Section -->

        <section class="bg-white px-8 rounded-lg overflow-hidden" x-data="{
            search: '{{ request('search') }}',
            selectedJob: null,
            appliedJobIds: @json($appliedJobIds),
            educational_attainment: '{{ request('educational_attainment') }}',
            employment_type: '{{ request('employment_type') }}',
            job_category: '{{ request('job_category') }}'
        }">
            <div>
                <h2 class="text-4xl font-bold text-center mb-4 mt-12">Job Referral</h2>
                <p class="text-center mb-6">Find your dream job from our list of available job openings.</p>
            </div>


            <div class="ralative flex justify-center mb-6 w-5/6 mx-auto">

                <div x-data="{ open: false }" class="relative flex text-left h-[60px]">
                    <!-- Filter Button -->
                    <button @click="open = !open"
                        class="flex items-center bg-blue-600 text-gray-700 px-3 py-2 rounded-lg h-[58px] hover:bg-blue-900 transition mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 mr-1" fill="white" viewBox="0 0 24 24"
                            stroke="white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v6l-4-2v-4L3 6V4z" />
                        </svg>
                        <span class="text-base font-medium text-white">Filter</span>
                    </button>

                    <!-- Dropdown Panel -->
                    <form action="{{ route('user.job.seeking') }}" method="GET">
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute left-0 mt-16 w-72 bg-white rounded-lg shadow-lg border border-gray-200 p-4 z-50">

                            <h3 class="text-center text-gray-700 font-semibold mb-3">Filter Options</h3>

                            <!-- Employment Type -->
                            <div class="mb-3">
                                <button
                                    class="flex justify-between w-full text-left text-sm font-semibold text-gray-800 border-b pb-1">
                                    By Employment Type
                                </button>
                                <x-dropdown-arrow>
                                    <select @click="open = !open" @blur="open = false" name="employment_type"
                                        x-model="employment_type"
                                        class="appearance-none w-full border rounded px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        <option value="">Select Type</option>
                                        <option value="Full-time">Full-time</option>
                                        <option value="Part-time">Part-time</option>
                                        <option value="Contractual">Contractual</option>
                                        <option value="Project-based">Project-based</option>
                                        <option value="Internship">Internship</option>
                                    </select>
                                </x-dropdown-arrow>
                            </div>


                            <!-- Job Category -->
                            <div class="mb-3">
                                <button
                                    class="flex justify-between w-full text-left text-sm font-semibold text-gray-800 border-b pb-1">
                                    By Job Category
                                </button>
                                <x-dropdown-arrow>
                                    <select @click="open = !open" @blur="open = false" name="job_category"
                                        x-model="job_category"
                                        class="appearance-none w-full border rounded px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        <option value="">Select Job Category</option>
                                        <option value="Blue Collar">Manual/Skilled Labor</option>
                                        <option value="White Collar">Office/Professional</option>
                                        <option value="Pink Collar">Service/Care Work</option>
                                        <option value="Green Collar">Environmental/Sustainability</option>
                                        <option value="Gray Collar">Tech/Specialized</option>
                                        <option value="Gold Collar">Highly Skilled/High Demand</option>
                                        <option value="Red Collar">Government/Military</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </x-dropdown-arrow>
                            </div>


                            <!-- Educational Attainment -->
                            <div class="mb-3">
                                <button
                                    class="flex justify-between w-full text-left text-sm font-semibold text-gray-800 border-b pb-1">
                                    By Educational Attainment
                                </button>
                                <x-dropdown-arrow>
                                    <select @click="open = !open" @blur="open = false" name="educational_attainment"
                                        x-model="educational_attainment"
                                        class="appearance-none w-full border rounded px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        <option value="">Select Level</option>
                                        <option value="Basic Education">Basic Education</option>
                                        <option value="High School Undergraduate">High School Undergraduate</option>
                                        <option value="High School Graduate">High School Graduate</option>
                                        <option value="College Undergraduate">College Undergraduate</option>
                                        <option value="College Graduate">College Graduate</option>
                                    </select>
                                </x-dropdown-arrow>
                            </div>

                            <!-- Footer Buttons -->
                            <div class="flex justify-around  mt-4">
                                <a class="px-3 py-1 font-medium text-gray-700 hover:text-black"
                                    href="/user-job-seeking">Clear</a>
                                <button
                                    class="bg-blue-600 font-medium text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Search</button>
                            </div>
                        </div>
                    </form>
                </div>

                <form action="{{ route('user.job.seeking') }}" method="GET" class="flex w-2/4">
                    <input type="text" placeholder="Search for jobs..."
                        class="flex-1 p-4 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="search" x-model="search">
                    <button type="submit"
                        class="bg-blue-600 text-base font-medium text-white px-6 rounded-r-lg hover:bg-blue-700 transition-colors duration-200">
                        Search
                    </button>
                </form>

                <a href="/user-job-profile"><img class="absolute right-[10%] h-[60px]"
                        src="{{ asset('images/profile-user.png') }}" alt="my profile">
                </a>
            </div>



            <div class="bg-white py-4">
                <div>
                    <h2 class="text-2xl font-bold mb-4 mx-auto w-5/6">JOBS FOR YOU</h2>
                </div>

                <div class="grid grid-cols-5 gap-6 w-5/6 mx-auto h-[90%]">
                    @if ($jobListings->where('status', 'Active')->isEmpty())
                        <div
                            class="bg-slate-100 col-span-5 h-full flex flex-1 items-center justify-center rounded-lg shadow">
                            <div class="text-center">
                                <div class="mb-4 flex justify-center h-32">
                                    <img class="opacity-75" src="{{ asset('images/empty-job-icon.png') }}"
                                        alt="No Requests">
                                </div>
                                <h2 class="text-xl font-semibold text-gray-700 mb-2">No Job Openings at the Moment</h2>
                                <p class="text-gray-600">Looks like there are no active job listings right now. Check
                                    back soon — new opportunities might be just around the corner!</p>
                            </div>
                        </div>
                    @else
                        <div class="col-span-2 rounded-l-lg text-black p-4 overflow-auto">
                            {{-- Job Listings --}}
                            @foreach ($jobListings->where('status', 'Active') as $job)
                                <div @click="selectedJob = {{ $job->toJson() }}"
                                    class="relative mb-6 p-4 bg-white rounded-lg shadow-lg hover:shadow-md transition-shadow duration-200 ease-in-out transform border border-gray-300">
                                    <div class="absolute top-0 left-0 h-3 w-full rounded-tl-lg rounded-tr-lg border-b border-gray-300"
                                        :class="{
                                            'bg-blue-400': '{{ $job->job_category }}'
                                            === 'Blue Collar',
                                            'bg-white': '{{ $job->job_category }}'
                                            === 'White Collar',
                                            'bg-pink-400': '{{ $job->job_category }}'
                                            === 'Pink Collar',
                                            'bg-green-400': '{{ $job->job_category }}'
                                            === 'Green Collar',
                                            'bg-gray-500': '{{ $job->job_category }}'
                                            === 'Gray Collar',
                                            'bg-yellow-400': '{{ $job->job_category }}'
                                            === 'Gold Collar',
                                            'bg-red-400': '{{ $job->job_category }}'
                                            === 'Red Collar',
                                            'bg-black': '{{ $job->job_category }}'
                                            === 'Other'
                                        }">
                                    </div>

                                    <div class="">
                                        <h3 class="text-3xl font-bold mb-2 p-2">{{ $job->job_title }}</h3>
                                        <div class="flex items-center px-2">
                                            <img class="h-4" src="{{ asset('images/company-icon.png') }}"
                                                alt="">
                                            <p class="px-2"> {{ $job->company->company_name }}</p>
                                        </div>

                                        <div class="flex items-center px-2">
                                            <img class="h-4" src="{{ asset('images/location-icon.png') }}"
                                                alt="">
                                            <p class="px-2">{{ $job->job_location }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="relative col-span-3 p-4 pt-0 overflow-auto">
                            <template x-if="selectedJob != null" class="w-full">
                                <div class="sticky top-0 h-3 w-full rounded-tl-lg rounded-tr-lg self-center"
                                    :class="{
                                        'bg-blue-400': selectedJob.job_category === 'Blue Collar',
                                        'bg-white': selectedJob.job_category === 'White Collar',
                                        'bg-pink-400': selectedJob.job_category === 'Pink Collar',
                                        'bg-green-400': selectedJob.job_category === 'Green Collar',
                                        'bg-gray-500': selectedJob.job_category === 'Gray Collar',
                                        'bg-yellow-400': selectedJob.job_category === 'Gold Collar',
                                        'bg-red-400': selectedJob.job_category === 'Red Collar',
                                        'bg-black': selectedJob.job_category === 'Other'
                                    }">
                                </div>
                            </template>

                            <div class=" h-full flex justify-center bg-gray-100 rounded-lg">
                                <template x-if="selectedJob == null">
                                    <div class="flex items-center justify-center h-full w-full">
                                        <div class="text-center text-black">
                                            <h2 class="text-2xl font-bold mb-4">Select a job to view details</h2>
                                            <p class="text-lg">Click on a job listing on the left to see more
                                                information
                                                about the job.</p>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="selectedJob != null" class="w-full">
                                    <div
                                        class="px-6 flex-1 min-h-fit bg-white rounded-lg shadow-lg flex flex-col text-black">
                                        <div class="sticky top-3 bg-white p-4 border-b border-black">

                                            <h2 class="text-3xl font-bold mb-4" x-text="selectedJob.job_title"></h2>
                                            <div class="flex justify-between">
                                                <div>
                                                    <div class="flex items-center">
                                                        <img class="h-5"
                                                            src="{{ asset('images/company-icon.png') }}"
                                                            alt="Company Icon">
                                                        <p class="ml-2 text-lg font-semibold"
                                                            x-text="selectedJob.company.company_name"></p>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <img class="h-5"
                                                            src="{{ asset('images/location-icon.png') }}"
                                                            alt="Location Icon">
                                                        <p class="ml-2 text-lg" x-text="selectedJob.job_location"></p>
                                                    </div>
                                                </div>
                                                <form class="text-center self-center"
                                                    :action="'/apply-to-job/' + selectedJob.id" method="GET">
                                                    @csrf
                                                    <button type="submit"
                                                        :disabled="appliedJobIds.includes(selectedJob.id)"
                                                        :class="appliedJobIds.includes(selectedJob.id) ?
                                                            'bg-gray-400 text-white font-bold px-6 py-3 rounded-lg cursor-not-allowed' :
                                                            'bg-blue-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-blue-800 transition-colors duration-200'">
                                                        <span
                                                            x-text="appliedJobIds.includes(selectedJob.id) ? 'Applied' : 'Apply Now'"></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>



                                        <!-- Body Sections -->
                                        <div class="p-6 space-y-8 text-gray-800 text-sm leading-relaxed">

                                            <!-- Job Details -->
                                            <section>
                                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Job details</h3>
                                                <div class="flex flex-wrap items-center gap-2">


                                                    <!-- Job Category -->
                                                    <template x-if="selectedJob.job_category">
                                                        <span
                                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-gray-500" viewBox="0 0 20 20"
                                                                :fill="{
                                                                    'Blue Collar': '#60A5FA', // blue-400
                                                                    'White Collar': '#FFFFFF', // white
                                                                    'Pink Collar': '#F472B6', // pink-400
                                                                    'Green Collar': '#34D399', // green-400
                                                                    'Gray Collar': '#6B7280', // gray-500
                                                                    'Gold Collar': '#FBBF24', // yellow-400
                                                                    'Red Collar': '#F87171', // red-400
                                                                    'Other': '#000000' // black
                                                                } [selectedJob.job_category] || '#000000'">
                                                                <circle cx="10" cy="10" r="8" />
                                                            </svg>
                                                            <span
                                                                x-text="{
                                                                'Blue Collar': 'Manual/Skilled Labor',
                                                                'White Collar': 'Office/Professional',
                                                                'Pink Collar': 'Service/Care Work',
                                                                'Green Collar': 'Environmental/Sustainability',
                                                                'Gray Collar': 'Tech/Specialized',
                                                                'Gold Collar': 'Highly Skilled/High Demand',
                                                                'Red Collar': 'Government/Military',
                                                                'Other': `${selectedJob.job_category} (Other)`
                                                            }[selectedJob.job_category] || selectedJob.job_category"></span>
                                                        </span>
                                                    </template>

                                                    <!-- Employment Type -->
                                                    <template x-if="selectedJob.employment_type">
                                                        <span
                                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-gray-500" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path d="M6 2a1 1 0 00-1 1v14l7-7-7-7z" />
                                                            </svg>
                                                            <span x-text="selectedJob.employment_type"></span>
                                                        </span>
                                                    </template>

                                                    <!-- Salary Range -->
                                                    <template x-if="selectedJob.min_salary || selectedJob.max_salary">
                                                        <span
                                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-gray-500" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 12H9v-2h2v2zm0-4H9V6h2v4z" />
                                                            </svg>
                                                            <span
                                                                x-text="selectedJob.min_salary ? '₱' + Number(selectedJob.min_salary).toLocaleString() : ''"></span>
                                                            <template
                                                                x-if="selectedJob.min_salary && selectedJob.max_salary">
                                                                <span>-</span>
                                                            </template>
                                                            <span
                                                                x-text="selectedJob.max_salary ? '₱' + Number(selectedJob.max_salary).toLocaleString() : ''"></span>
                                                        </span>
                                                    </template>

                                                    <!-- Age Requirement -->
                                                    <template x-if="selectedJob.min_age || selectedJob.max_age">
                                                        <span
                                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-gray-500" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 12H9v-2h2v2zm0-4H9V6h2v4z" />
                                                            </svg>
                                                            <span
                                                                x-text="selectedJob.min_age ? selectedJob.min_age : ''"></span>
                                                            <template
                                                                x-if="selectedJob.min_age && selectedJob.max_age">
                                                                <span>-</span>
                                                            </template>
                                                            <span
                                                                x-text="selectedJob.max_age ? selectedJob.max_age : ''"></span>
                                                            <span>years old</span>
                                                        </span>
                                                    </template>

                                                    <!-- Height Requirement -->
                                                    <template x-if="selectedJob.min_height || selectedJob.max_height">
                                                        <span
                                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-gray-500" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <rect x="4" y="8" width="12" height="4" />
                                                            </svg>
                                                            <span
                                                                x-text="selectedJob.min_height ? selectedJob.min_height + 'cm' : ''"></span>
                                                            <template
                                                                x-if="selectedJob.min_height && selectedJob.max_height">
                                                                <span>-</span>
                                                            </template>
                                                            <span
                                                                x-text="selectedJob.max_height ? selectedJob.max_height + 'cm' : ''"></span>
                                                        </span>
                                                    </template>

                                                    <!-- Weight Requirement -->
                                                    <template x-if="selectedJob.min_weight || selectedJob.max_weight">
                                                        <span
                                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-gray-500" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <ellipse cx="10" cy="10" rx="8"
                                                                    ry="5" />
                                                            </svg>
                                                            <span
                                                                x-text="selectedJob.min_weight ? selectedJob.min_weight + 'kg' : ''"></span>
                                                            <template
                                                                x-if="selectedJob.min_weight && selectedJob.max_weight">
                                                                <span>-</span>
                                                            </template>
                                                            <span
                                                                x-text="selectedJob.max_weight ? selectedJob.max_weight + 'kg' : ''"></span>
                                                        </span>
                                                    </template>

                                                    <!-- Educational Attainment -->
                                                    <template x-if="selectedJob.educational_attainment">
                                                        <span
                                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-gray-500" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M10 2L2 7l8 5 8-5-8-5zm0 13a7 7 0 01-7-7h2a5 5 0 0010 0h2a7 7 0 01-7 7z" />
                                                            </svg>
                                                            <span x-text="selectedJob.educational_attainment"></span>
                                                        </span>
                                                    </template>

                                                    <!-- Special Program -->
                                                    <template x-if="selectedJob.special_program">
                                                        <span
                                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-gray-500" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path d="M4 4h12v12H4z" />
                                                            </svg>
                                                            <span x-text="selectedJob.special_program"></span>
                                                            <template x-if="selectedJob.is_special_program_optional">
                                                                <span
                                                                    class="ml-1 text-xs text-gray-500">(Optional)</span>
                                                            </template>
                                                        </span>
                                                    </template>

                                                    <!-- Certificate Number -->
                                                    <template x-if="selectedJob.certificate_number">
                                                        <span
                                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-gray-500" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M16.707 6.293a1 1 0 00-1.414 0L9 12.586 6.707 10.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            <span>Certificate</span>
                                                        </span>
                                                    </template>

                                                </div>
                                            </section>



                                            <!-- Location -->
                                            <section>
                                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Location</h3>
                                                <div class="flex items-center text-gray-700">
                                                    <img class="h-4 m-1"
                                                        src="{{ asset('images/location-icon.png') }}">
                                                    <p class="text-base" x-text="selectedJob.job_location"></p>
                                                </div>
                                            </section>

                                            <!-- Full Job Description -->
                                            <section>
                                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Full job
                                                    description
                                                </h3>
                                                <p class="whitespace-pre-line text-base"
                                                    x-text="selectedJob.job_description"></p>
                                            </section>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </section>
    @else
        @guest
            <section class="relative z-[1]">
                <img src="{{ asset('images/barangay-lawang-bato-3s-hero-section.jpg') }}" alt="Job Hunting Banner"
                    class="w-full h-80 object-cover">
                <div
                    class="absolute inset-0 flex flex-col items-center justify-center text-white text-center bg-black bg-opacity-50 ">
                    <h2 class="text-7xl font-bold">Job Referral</h2>
                    <p class="text-xl mt-4">
                        The Job Referral section lets residents submit their requirements and admin will help them to find
                        for easier employment from partner companies.
                    </p>
                </div>
            </section>

            <section
                class="bg-white overflow-x-hidden relative min-h-fit text-center h-full w-full flex flex-col justify-center">

                <!-- Background image -->
                <div
                    class="absolute w-full left-1/3 inset-0 opacity-5 flex justify-center items-center pointer-events-none">
                    <img src="{{ asset('images/lawang-bato-logo.png') }}" alt="Lawang Bato Logo"
                        class="h-[135vh] w-[135vh] select-none">
                </div>


                <section class="grid grid-cols-3 items-center py-20 w-3/5 mx-auto gap-4">
                    <div class="col-span-2">
                        <h2 class="text-3xl font-bold text-left">Why Choose Job Referrals?</h2>
                        <p class="mt-4 text-lg text-justify">
                            Getting referred through the barangay increases your chances of employment! Referrals help
                            connect you directly with trusted partner companies, making the hiring process faster and more
                            reliable. Plus, it shows employers that your application has been pre-verified by the
                            barangay—giving you an edge over other applicants.
                        </p>
                    </div>

                    <div class="col-span-1 flex justify-center rounded-lg shadow-lg w-fit">
                        <img class="object-contain max-h-full h-[200px]"
                            src="{{ asset('images/why-choose-job-referral.png') }}" alt="Lawang Bato Logo">
                    </div>
                </section>

                <hr class="flex-1 w-4/5 border-gray-500 border-t mx-auto">

                <section class="flex flex-col items-center py-20 w-4/5 mx-auto space-y-16">
                    <div class="">
                        <h2 class="text-3xl font-bold text-center">Job Referral Process</h2>
                        <p class="mt-4 text-lg text-center">
                            Easily find and apply for jobs through the Barangay Lawang Bato Website. Follow these steps to
                            start your application journey:
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="flex flex-col gap-2 px-6">
                            <div class="flex justify-center h-[130px]">
                                <img src="{{ asset('images/login-signup.png') }}" alt="">
                            </div>
                            <div>
                                <h3 class="flex justify-center items-center text-xl font-bold text-center min-h-14">Log in/
                                    Sign up</h3>
                                <p class="mt-4 text-lg text-center">Create your account and wait for the admin to approve
                                    it. Once approved, you can log in.</p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 px-6">
                            <div class="flex justify-center h-[130px]">
                                <img src="{{ asset('images/browse-and-apply.png') }}" alt="">
                            </div>
                            <div>
                                <h3 class="flex justify-center items-center text-xl font-bold text-center min-h-14">Browse
                                    & Apply</h3>
                                <p class="mt-4 text-lg text-center">Explore job listings from partner companies and submit
                                    your application to your desired position.</p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 px-6">
                            <div class="flex justify-center h-[130px]">
                                <img src="{{ asset('images/referral.png') }}" alt="">
                            </div>
                            <div>
                                <h3 class="flex justify-center items-center text-xl font-bold text-center min-h-14">Get
                                    Referred & <br>Wait for Company Update</h3>
                                <p class="mt-4 text-lg text-center"> After admin approval, your application will be
                                    referred to the company. Kindly wait for their response.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="flex-1 w-4/5 border-gray-500 border-t mx-auto">

                <div class="relative flex flex-col items-center py-20 w-2/5 mx-auto">
                    <h2 class="text-2xl font-bold mb-6">ARE YOU LOOKING FOR A <span class="text-blue-500">JOB</span>?</h2>
                    <div class="w-full max-w-md bg-gray-100 p-8 rounded-lg shadow-lg flex flex-col items-center">
                        <h3 class="text-xl font-bold mb-4">Log In</h3>
                        <form action="{{ route('user.login') }}" method="POST" class="w-full flex flex-col">
                            @csrf
                            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                                class="w-full px-4 py-2 mb-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">


                            <div x-data="{ show: false }" class="relative">

                                <input :type="show ? 'text' : 'password'" name="password" placeholder="Password"
                                    class="w-full px-4 py-2 mb-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

                                <button type="button" @click="show = !show"
                                    class="absolute top-[23%] right-0 pr-3 flex items-center text-gray-500"
                                    tabindex="-1">
                                    <!-- Eye icon (hidden) -->
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>

                                    <!-- Eye-off icon (visible) -->
                                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.96 9.96 0 012.6-4.362m2.77-1.93A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.957 9.957 0 01-4.253 5.04M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>


                            @error('email')
                                <p class="text-red-500 text-sm mt-1 mb-2">{{ $message }}</p>
                            @enderror

                            @error('password')
                                <p class="text-red-500 text-sm mt-1 mb-2">{{ $message }}</p>
                            @enderror


                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <a href="#" class="hover:underline">Forgot Password?</a>
                            </div>
                            <button
                                class="w-full mt-2 bg-blue-600 text-white py-2 rounded-lg font-semibold text-center hover:bg-blue-700 transition-colors duration-200 shadow-lg">Login</button>
                        </form>
                        <p class="mt-4 text-sm">Don't have an account?
                            <a href="/user-account-registration" class="text-blue-500 hover:underline">
                                Sign Up
                            </a>
                        </p>
                    </div>
                    <div class="mt-8 w-full max-w-md flex justify-center">
                        <a href="/company-login" target="_blank" rel="noopener noreferrer"
                            class="w-full bg-gray-800 text-white px-4 py-3 rounded-lg font-semibold text-center hover:bg-gray-900 transition-colors duration-200 shadow-lg">
                            Log in as Company
                        </a>
                    </div>
                </div>

            </section>
        @endguest




        @if (@auth()->user()?->status == 'Pending')
            <section
                class="relative overflow-hidden bg-white text-center h-full mx-auto p-6 rounded-lg shadow-lg flex flex-col items-center justify-center">

                <!-- Background image -->
                <div
                    class="absolute w-full left-1/3 inset-0 opacity-5 flex justify-center items-center pointer-events-none">
                    <img src="{{ asset('images/lawang-bato-logo.png') }}" alt="Lawang Bato Logo"
                        class="h-[135vh] w-[135vh] select-none">
                </div>

                <div class="relative z-10">
                    <div>
                        <!-- Icon / Illustration -->
                        <div class="mb-4 flex justify-center h-32">
                            <!-- You can replace this with an actual SVG or image if needed -->
                            <img class="opacity-80 pointer-events-none"
                                src="{{ asset('images/pending-account-icon.png') }}" alt="Pending Account">
                        </div>

                        <h2 class="text-2xl font-bold mb-4">Your account is currently pending approval.</h2>
                        <p class="text-gray-600">Please wait for the admin to approve your account.</p>
                    </div>

                    <form method="POST" action="{{ route('user.logout') }}">
                        @csrf
                        <button type="submit"
                            class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-800">
                            Log in with another account
                        </button>
                    </form>
                </div>


            </section>
        @elseif (@auth()->user()?->status == 'Rejected')
            <section
                class="relative overflow-hidden bg-white text-center h-full mx-auto p-6 rounded-lg shadow-lg flex flex-col items-center justify-center">

                <!-- Background image -->
                <div
                    class="absolute w-full left-1/3 inset-0 opacity-5 flex justify-center items-center pointer-events-none">
                    <img src="{{ asset('images/lawang-bato-logo.png') }}" alt="Lawang Bato Logo"
                        class="h-[135vh] w-[135vh] select-none">
                </div>

                <div class="relative z-10">
                    <div>
                        <!-- Icon / Illustration -->
                        <div class="mb-4 flex justify-center h-32">
                            <!-- You can replace this with an actual SVG or image if needed -->
                            <img class="opacity-80 pointer-events-none"
                                src="{{ asset('images/rejected-account-icon.png') }}" alt="Rejected Account">
                        </div>

                        <h2 class="text-2xl font-bold mb-4">Your account has been rejected.</h2>
                        <p class="text-gray-600">Please check your email for the reason of account rejection. <br>
                            Contact
                            the admin for more information.</p>
                    </div>

                    <form method="POST" action="{{ route('user.logout') }}">
                        @csrf
                        <button type="submit"
                            class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-800">
                            Log in with another account
                        </button>
                    </form>
                </div>
            </section>
        @elseif (@auth()->user()?->status == 'Deactivated')
            <section
                class="relative overflow-hidden bg-white text-center h-full mx-auto p-6 rounded-lg shadow-lg flex flex-col items-center justify-center">
                <div>
                    <h2 class="text-2xl font-bold mb-4">Your account has been deactivated.</h2>
                    <p class="text-gray-600">Please check your email for the reason of account deactivation. <br>
                        Contact the admin for more information.</p>
                </div>

                <form method="POST" action="{{ route('user.logout') }}">
                    @csrf
                    <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-800">
                        Log in with another account
                    </button>
                </form>
            </section>
        @endif

        @include('user/user-footer')
    @endif

    {{-- Action Successful Toast --}}
    <div x-cloak x-show="showSuccessNotificationToast" x-transition x-cloak x-init="setTimeout(() => showSuccessNotificationToast = false, 7000)"
        class="fixed top-20 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">

        {{ session('success') }}
    </div>

    @livewireScripts
    
</body>

</html>
