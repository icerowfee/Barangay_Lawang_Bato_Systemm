<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body class="flex h-screen bg-gray-100" x-data="{
    isEditing: false,
    originalData: {},
    viewUploadedImage: false,
    selectedOfficial: null,
    skOfficials: {{ $skOfficials->toJson() }},
    showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }},

    saveOriginalData() {
        this.originalData = JSON.parse(JSON.stringify(this.skOfficials)); // Deep copy data
    },

    restoreOriginalData() {
        this.skOfficials = JSON.parse(JSON.stringify(this.originalData)); // Restore from backup
    }
}">

    <!-- Sidebar -->
    @include('super-admin/super-admin-side-panel')

    <!-- Main Content (Placeholder) -->
    <main class="relative h-screen flex-1 p-8 overflow-y-scroll">
        <h1 class="text-3xl font-bold mb-6">Manage SK Officials</h1>

        <!-- Officials List -->
        <form action="/update-sk-official-list" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-3 gap-6">
                <template x-for="(skOfficial, index) in skOfficials" :key="index">
                    <div class="bg-white p-8 rounded shadow-lg">
                        <template x-if="skOfficial.position === 'SK Chairman'">
                            <h2 class="font-bold" x-text="skOfficial.position"></h2>
                        </template>
                        <template x-if="skOfficial.position === 'SK Secretary'">
                            <h2 class="font-bold" x-text="skOfficial.position"></h2>
                        </template>
                        <template x-if="skOfficial.position === 'SK Treasurer'">
                            <h2 class="font-bold" x-text="skOfficial.position"></h2>
                        </template>
                        <template
                            x-if="skOfficial.position != 'SK Chairman' && skOfficial.position != 'SK Secretary' && skOfficial.position != 'SK Treasurer'">
                            <h2 class="font-bold">SK Kagawad</h2>
                        </template>

                        <!-- Name Input -->
                        <label class="block mt-2">Name:</label>
                        <input type="text" x-model="skOfficial.name" class="w-full p-2 border rounded"
                            :disabled="!isEditing">

                        <!-- Image Input -->
                        <label>Image:</label>
                        <input type="file" :name="'skOfficials[' + index + '][sk_official_image]'"
                            class="w-full border p-2 rounded-lg" x-cloak x-show="isEditing">

                        <template x-if="!isEditing">
                            <button type="button" class="border p-2 rounded w-full h-[48px]"
                                @click="
                                        selectedOfficial = skOfficial; 
                                        if (selectedOfficial.sk_official_image) { 
                                            viewUploadedImage = true; 
                                        }
                                    "
                                x-cloak x-show="!isEditing">View Image</button>
                        </template>

                        <!-- Hidden Position Input -->
                        <input type="hidden" name="skOfficials[][position]" :value="skOfficial.position">
                    </div>
                </template>
            </div>

            <!-- Image View Modal -->
            <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4" x-cloak
                x-show="viewUploadedImage" @click.away="viewUploadedImage = false">

                <div class="relative bg-white p-4 rounded-lg shadow-lg w-[80%] max-w-[400px]">
                    <!-- Ensures a portrait aspect ratio and centers the image -->

                    <!-- Close Button -->
                    <button type="button"
                        class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                        @click="viewUploadedImage = false">
                        ✕
                    </button>

                    <!-- Image Display -->
                    <template x-if="selectedOfficial && selectedOfficial.sk_official_image">
                        <div
                            class="w-full aspect-[4/5] bg-gray-200 flex items-center justify-center overflow-hidden rounded-lg">
                            <img :src="'/storage/' + selectedOfficial.sk_official_image" alt="Official's Image"
                                class="w-full h-full object-cover">
                        </div>
                    </template>

                    {{-- <!-- Debugging: Show the selected official's image path -->
                    <p class="mt-2 text-center text-sm text-gray-500" 
                    x-text="selectedOfficial ? selectedOfficial.sk_official_image : 'No image selected'"></p> --}}
                </div>
            </div>



            <!-- Hidden Input to Send Data -->
            <input type="hidden" name="skOfficials_data" :value="JSON.stringify(skOfficials)">

            <!-- Save and Cancel Buttons -->
            <div class="fixed bottom-0 right-10 flex justify-end w-full p-4" x-cloak x-show="isEditing">
                <div class="space-x-4">
                    <button class="bg-gray-800 text-white px-6 py-2 rounded" type="submit">SAVE</button>
                    <button type="button" class="bg-gray-600 text-white px-6 py-2 rounded"
                        @click="isEditing = false; restoreOriginalData()" type="button">CANCEL</button>
                </div>
            </div>
        </form>

        <!-- Edit Button -->
        <div class="fixed bottom-0 right-10 flex justify-end w-full p-4" x-cloak x-show="!isEditing">
            <button type="button" class="bg-gray-800 text-white px-6 py-2 rounded"
                @click="isEditing = true; saveOriginalData()">EDIT</button>
        </div>

        {{-- Action Successful Toast --}}
        <div x-cloak x-show="showSuccessNotificationToast" x-transition x-cloak x-init="setTimeout(() => showSuccessNotificationToast = false, 3000)"
            class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">

            {{ session('success') }}
        </div>

    </main>

    <script>
        function saveOriginalData() {
            this.originalData = {
                punongBarangayName: document.querySelector('input[x-model="originalData.punongBarangayName"]').value,
                kagawadNames: Array.from(document.querySelectorAll('input[x-model^="originalData.kagawadNames"]')).map(
                    input => input.value)
            };
        }

        function restoreOriginalData() {
            document.querySelector('input[x-model="originalData.punongBarangayName"]').value = this.originalData
                .punongBarangayName;
            Array.from(document.querySelectorAll('input[x-model^="originalData.kagawadNames"]')).forEach((input, index) => {
                input.value = this.originalData.kagawadNames[index];
            });
        }
    </script>

    @livewireScripts

</body>

</html>
