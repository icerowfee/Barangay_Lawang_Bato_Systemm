<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Request Status</title>
</head>

<body class="bg-[#EBF0FF]">
    @include('user/user-header')

    <section class="relative z-[-1]">
        <img src="{{ asset('images/barangay-lawang-bato-3s-hero-section.jpg') }}" alt="Job Hunting Banner"
            class="w-full h-80 object-cover">
        <div
            class="absolute inset-0 flex flex-col items-center justify-center text-white text-center bg-black bg-opacity-50 ">
            <h2 class="text-4xl font-bold">Job Referral Request Status</h2>
            <p class="mt-2">
                The Job Referral section lets residents submit their requirements and admin will help them to find for
                easier employment from partner companies.
            </p>
        </div>
    </section>

    @if ($jobReferralRequest->status == 'Referred')


    
    @else
        <section class="flex flex-col py-20 ">
            <!-- Status & Info -->
            <div class="text-5xl font-bold text-[#2a3552] mb-4 px-40">
                STATUS:
                <span class="text-red-600 font-bold">{{ $jobReferralRequest->status }}</span>
            </div>

            <div class="relative bg-white rounded-tr-[15rem] p-6 shadow-md w-3/5 h-96">
                <div class="text-3xl text-gray-700 space-y-2 px-12 py-10">
                    <p class="py-4"><span class="font-semibold">Name:</span> <span
                            class="text-black font-medium">{{ $jobReferralRequest->user->lastname . ', ' . $jobReferralRequest->user->firstname . ' ' . $jobReferralRequest->user?->middlename }}</span>
                    </p>
                    <p class="py-4"><span class="font-semibold">Email:</span> <span
                            class="text-black font-medium">{{ $jobReferralRequest->user->email }}</span></p>
                    <p class="py-4"><span class="font-semibold">Contact number:</span> <span
                            class="text-[#1d3557] font-semibold">{{ $jobReferralRequest->user->contact_number }}</span>
                    </p>
                </div>

                <div class="absolute right-[25%] flex justify-start items-center gap-4 mt-4">
                    <a href="#"
                        class="bg-[#1d3557] text-white h-16 px-8 py-4 rounded-full text-l text-center font-medium hover:bg-[#16324f] transition">
                        View Requirements
                    </a>
                    <button class="bg-red-600 text-white p-6 rounded-full hover:bg-red-700 transition">
                        <!-- Trash Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v2H9V4a1 1 0 011-1z" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    @endif



    @include('user/user-footer')

    @livewireScripts

</body>

</html>
