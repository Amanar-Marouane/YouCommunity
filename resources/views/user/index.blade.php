<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <x-header></x-header>
    <div class="mb-4 text-white rounded-lg bg-green-500 border-l-4 border-green-700 shadow-md">
        <p>{{ session('success') ?? '' }}</p>
    </div>
    <div class="mb-4 text-white rounded-lg bg-red-500 border-l-4 border-red-700 shadow-md">
        <p>{{ session('error') ?? '' }}</p>
    </div>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
            </div>
        </div>


        <form action="/profile" method="POST" class="inline">
            @csrf
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg mb-6 hover:bg-blue-700 transition duration-300">
                Edit Profile
            </button>
        </form>
        <button onclick="toggleEventForm()"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg mb-6 hover:bg-blue-700 transition duration-300">
            Add New Event
        </button>

        <div id="eventForm" class="hidden bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Create New Event</h2>
            <form action="{{ route('event.create') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-gray-700 mb-2" for="title">Event Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <p class="text-sm text-gray-500">Required. Max: 255 characters.</p>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="description">Description</label>
                    <textarea id="description" name="description" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ old('description') }}</textarea>
                    <p class="text-sm text-gray-500">Required. Max: 1000 characters.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-2" for="category">Category</label>
                        <select id="category" name="category_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2" for="date">Date & Time</label>
                        <input type="datetime-local" id="date" name="begin_at" value="{{ old('begin_at') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <p class="text-sm text-gray-500">Required. Must be a future date.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="location">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <p class="text-sm text-gray-500">Required. Max: 255 characters.</p>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="max_participants">Maximum Participants</label>
                    <input type="number" id="max_participants" name="max_participants"
                        value="{{ old('max_participants') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <p class="text-sm text-gray-500">Required. Min: 10, Max: 1000.</p>
                </div>

                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Create Event
                </button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Your Events</h2>
            <div class="space-y-4">
                @foreach ($events as $event)
                    @unless ($event->is_deleted == 1)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ $event->title }}</h3>
                                    <p class="text-gray-600">{{ $event->description }}</p>
                                    <div class="mt-2 space-x-2">
                                        <span class="text-sm text-gray-500">{{ $event->begin_at }}</span>
                                        <span class="text-sm text-gray-500">•</span>
                                        <span class="text-sm text-gray-500">{{ $event->location }}</span>
                                    </div>
                                    <div class="mt-2">
                                        <span class="inline-block bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded">
                                            {{ $event->category->name }}
                                        </span>
                                        <span
                                            class="inline-block bg-green-100 text-green-800 text-sm px-2 py-1 rounded ml-2">
                                            {{ $event->current_participants_count }}/{{ $event->max_participants }}
                                            participants
                                        </span>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('event.edit', $event->id) }}">
                                        <button class="text-blue-600 hover:text-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    </a>
                                    <form action="{{ route('event.softDelete', ['id' => $event->id]) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endunless
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function toggleEventForm() {
            const form = document.getElementById('eventForm');
            form.querySelector("form").reset();
            form.classList.toggle('hidden');
        }

        function editEvent(eventId) {
            window.location.href = `/events/${eventId}/edit`;
        }
    </script>
</body>

</html>
