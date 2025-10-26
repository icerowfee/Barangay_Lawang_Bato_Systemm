<footer>
    <div class="  bg-blue-950 flex flex-col justify-center text-white ">
        <div class="container mx-auto flex justify-between items-center py-10 px-2">
            <div>
                <div class="flex flex-col w-fit">
                    <div class="flex justify-center gap-2">
                        <img class="h-[80px]" src="{{asset('images/lawang-bato-logo.png')}}" alt="barangay-lawang-bato-logo">
                        <img class="h-[80px]" src="{{asset('images/lawang-bato-sk-logo.png')}}" alt="barangay-lawang-bato-logo">
                    </div>
                    <h1 class="text-2xl font-bold">Barangay Lawang Bato</h1>
                </div>
                
                <p class="mt-4">A Barangay that is God-centered, competent, orderly, honest, <br> 
                    peaceful, credible, gender responsive and abides the Code of Conduct.
                </p>
            </div>
            <div class="flex justify-between w-1/5">
                <div class="flex flex-col space-y-2">
                    <a href="/user-home-page" class=" text-white-800">Home</a>
                    <a href="/user-about-page" class=" text-white-800">Our Barangay</a>
                    <a href="/user-cedula-request" class=" text-white-800">Services</a>
                    <a href="/user-contact-us-page" class=" text-white-800">Contact</a>
                </div>
                <div class="flex flex-col space-y-2">
                    <a class=" text-white-800 cursor-pointer" @click="$dispatch('open-privacy-policy')">Privacy Policy</a>
                    <a href="#" class=" text-white-800">Terms and Conditions</a>
                    <a href="#" class=" text-white-800">Disclaimers</a>
                </div>
            </div>
        </div>
        <div class="bg-red-800 flex justify-center items-center">
            <p class="text-center my-1">© 2021 Barangay Lawang Bato. All Rights Reserved.</p>
        </div>
    </div>

    
    <x-privacy-policy-modal />
    
</footer>