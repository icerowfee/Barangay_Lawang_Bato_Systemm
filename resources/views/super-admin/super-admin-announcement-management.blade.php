<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Announcement</title>
    
</head>
<body class="flex h-screen bg-gray-100" x-data="{
    showModal: false, 
    showAnnouncementModal: false,
    selectedAnnouncement: null,
    editMode: false,
    viewUploadedImage: false,
    tempAnnouncement: null,
    showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }},

    startEditing() {
        this.tempAnnouncement = JSON.parse(JSON.stringify(this.selectedAnnouncement)); // Create a deep copy
        this.editMode = true;
    },
    cancelEditing() {
        this.selectedAnnouncement = JSON.parse(JSON.stringify(this.tempAnnouncement)); // Restore values
        this.editMode = false;
    }
}">
    <!-- Sidebar -->
    @include('super-admin/super-admin-side-panel')

    <!-- Main Content (Placeholder) -->
    <div class="relative h-screen flex-1 p-8 overflow-y-scroll">
        <h1 class="text-3xl font-bold mb-10 ">Announcement Management</h1>
        @if($announcements->isEmpty())
            <div class="w-full h-[70vh] flex items-center justify-center">
                <div class=" text-center">
                    <!-- Icon / Illustration -->
                    <div class="mb-4 flex justify-center h-32">
                        <!-- You can replace this with an actual SVG or image if needed -->
                        <img src="{{asset('images/announcement-icon.png')}}" alt="No Admin">
                    </div>
            
                    <!-- Title -->
                    <h2 class="text-xl font-semibold text-gray-600 mb-2">Announcement Board is Empty</h2>
            
                    <!-- Subtitle -->
                    <p class="text-gray-500">Time to add something important for the community.</p>
                </div>
            </div>
        @else
        <div class="">
            <template" class="grid grid-cols-3 gap-6 mx-12">
                @foreach ($announcements as $announcement)
                    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition cursor-pointer h-[467px] w-full overflow-hidden" @click="selectedAnnouncement = {{ $announcement->toJson() }}; showAnnouncementModal = true;">
                        <img src="{{ asset('storage/' . $announcement['announcement_image']) }}" alt="Announcement Image" class="h-40 w-full object-cover rounded-t-lg mb-4">
                        <h2 class="text-xl font-bold mb-2">{{$announcement['title']}}</h2>
                        <h3 class="text-md font-semibold mb-2">{{$announcement['heading']}}</h3>
                        <p class="text-gray-500 mb-2">{{$announcement['start_date']}} - {{$announcement['end_date']}}</p>
                        <p class="text-gray-700 h-36 overflow-y-clip ">{{$announcement['body']}}</p>
                    </div>
                    
                @endforeach
            </template>
            
        </div>
        @endif
        
        <div class="fixed bottom-0 right-8 flex justify-end w-full p-4">
            <div class="space-x-4">
                <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition" @click="showModal = true">
                    Add Announcement
                </button>
            </div>
        </div>

        <!-- Popup for Active Announcements -->
        <div x-cloak x-show="showAnnouncementModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class=" relative bg-white p-6 rounded-lg shadow-lg w-[750px] h-content">
                <div class="flex justify-between mb-2">
                    <h2 class=" w-full text-center ml-[63px] text-[30px] font-bold">Review Announcement</h2>
                    <button class=" text-[15px] max-h-[25px] w-6 text-black" @click="showAnnouncementModal = false; cancelEditing()">
                        X
                    </button>
                </div>

                <div class="mx-5 text-[17px]">
                    <!-- Title and Heading -->
                    <div class="flex flex-col justify-between m-2">
                        <p><strong>Title</strong></p>
                        <input type="text" class="w-full border p-2 rounded-lg mb-4" x-model="selectedAnnouncement.title" :readonly= !editMode>
                    </div>

                    <div class="flex flex-col justify-between m-2">
                        <p><strong>Heading</strong></p>
                        <input type="text" class="w-full border p-2 rounded-lg mb-4" x-model="selectedAnnouncement.heading" :readonly= !editMode>
                    </div>

                    <div class="flex justify-between">
                        <!-- Start Date -->
                        <div class="flex flex-col m-2">
                            <label><strong>Start Date</strong></label>
                            <input type="date" x-model="selectedAnnouncement.start_date" class="border p-2 rounded w-full" :readonly= !editMode>
                        </div>

                        <!-- End Date -->
                        <div class="flex flex-col m-2">
                            <label><strong>End Date</strong></label>
                            <input type="date" x-model="selectedAnnouncement.end_date" class="border p-2 rounded w-full" :readonly= !editMode>
                        </div>

                        
                        

                        <!-- Announcement Type -->
                        <div class="flex flex-col justify-between m-2">
                            <p><strong>Announcement Type</strong></p>
                            <select x-model="selectedAnnouncement.announcement_type" class="w-full border p-2 rounded-md border-gray-300 h-[48px]" :disabled= !editMode>
                                <option value="Regular Announcement">Regular Announcement</option>
                                <option value="Job Announcement">Job Announcement</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col m-2 w-full">
                        <template x-if="!editMode">
                            <label><strong>Uploaded Image</strong></label>
                        </template>
                    
                        <template x-if="editMode">
                            <label><strong>Upload Image</strong></label>
                        </template>
                        
                        <template x-if="!editMode">
                            <button class="border p-2 rounded w-full h-[49.5px]" @click= "viewUploadedImage = true"  >View Image</button>
                        </template>
                    
                        <template x-if="editMode">
                            <input type="file" x-model="announcement_image" class="border p-2 rounded w-full">
                        </template>
                    </div>
                    
                    <div class="flex flex-col m-2 ">
                        <p><strong>Body</strong></p>
                        <textarea class="w-full border p-2 rounded-lg mb-4 h-[277px]" x-model="selectedAnnouncement.body" :readonly= !editMode></textarea>
                    </div>
                </div>


                <!-- Popup for Viewing Uploaded Image -->
                <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4" 
                    x-cloak x-show="viewUploadedImage" 
                    @click.away="viewUploadedImage = false">
                    <div class="relative bg-white p-4 rounded-lg shadow-lg w-[80%] max-w-[1000px]">
                        <!-- Close Button -->
                        <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                                @click="viewUploadedImage = false">
                            ✕
                        </button>
                
                        <!-- Image Display -->
                        <template x-if="selectedAnnouncement.announcement_image">
                            <img :src="'/storage/' + selectedAnnouncement.announcement_image" 
                                    alt="Uploaded Image" 
                                    class="w-full h-[400px] object-cover rounded-lg">
                        </template>
                    </div>
                </div>
                

                <!-- Action Buttons -->
                <div class=" w-[702px] flex justify-center self-center">
                    <div class="flex justify-between w-[225px]" x-cloak x-show="!editMode">
                        <form action="{{route('delete.announcement')}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" :value="selectedAnnouncement.id">
                            <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600 transition">
                                Delete
                            </button>
                        </form>

                        <button class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition" @click="startEditing()">
                            Edit
                        </button>
                    </div>

                    <div class="flex justify-between w-[225px]" x-cloak x-show="editMode">
                        <form action="{{route('edit.announcement')}}" method="POST" enctype="multipart/form-data"> {{-- Need ayusin yung sa file upload, hindi na uupload yung image sa storage--}}
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" :value="selectedAnnouncement.id">
                            <input type="hidden" name="title" :value="selectedAnnouncement.title">
                            <input type="hidden" name="heading" :value="selectedAnnouncement.heading">
                            <input type="hidden" name="start_date" :value="selectedAnnouncement.start_date">
                            <input type="hidden" name="end_date" :value="selectedAnnouncement.end_date">
                            <input type="hidden" name="announcement_image" :value="selectedAnnouncement.announcement_image"> 
                            <input type="hidden" name="announcement_type" :value="selectedAnnouncement.announcement_type"> 
                            <input type="hidden" name="body" :value="selectedAnnouncement.body">

                            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition" @click="editMode = false">
                                Save
                            </button>
                        </form>

                        
                        <button class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600 transition" @click="cancelEditing()">
                            Cancel
                        </button>
                        
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    {{-- Action Successful Toast --}}
    <div 
        x-cloak x-show="showSuccessNotificationToast"
        x-transition
        x-cloak
        x-init="setTimeout(() => showSuccessNotificationToast = false, 3000)"
        class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        
        {{ session('success') }}
    </div>

    <!-- Announcement Modal -->
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50" x-cloak x-show="showModal">
        <div class="bg-white p-6 rounded-lg w-1/3 shadow-lg">
            <form action="{{route('add.announcement')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <h2 class="text-2xl font-bold mb-4 text-center">Add Announcement</h2>

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-600 rounded">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label class="block mb-2">Title:</label>
                <input type="text" name="title" class="w-full border p-2 rounded-lg mb-4">
                <label class="block mb-2">Heading:</label>
                <input type="text" name="heading" class="w-full border p-2 rounded-lg mb-4">
                <label class="block mb-2">Start Date:</label>
                <input type="date" name="start_date" class="w-full border p-2 rounded-lg mb-4">
                <label class="block mb-2">End Date:</label>
                <input type="date" name="end_date" class="w-full border p-2 rounded-lg mb-4">
                <label class="block mb-2">Description:</label>
                <textarea name="body" class="w-full border p-2 rounded-lg mb-4"></textarea>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-2">Upload Image:</label>
                        <input type="file" name="announcement_image" class="w-full border p-2 rounded-lg">
                        <img :src="newImage" alt="Preview Image" class="h-40 w-full object-cover rounded-lg" x-cloak x-show="newImage">
                    </div>
                    <div>
                        <label class="block mb-2">Announcement Type:</label>
                        <select name="announcement_type" required class="w-full border p-2 rounded-md border-gray-300 h-[48px]">
                            <option value="Regular Announcement">Regular Announcement</option>
                            <option value="Job Announcement">Job Announcement</option>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="status" value="Active">
                
                <div class="flex justify-end space-x-4">
                    <button type="button" class="px-4 py-2 bg-gray-400 text-white rounded-lg" @click="showModal = false">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg">Add</button>
                </div>
            </form>
        </div>
    </div>

    @livewireScripts
    
</body>
</html>
