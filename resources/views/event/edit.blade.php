<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <div class="mb-4 text-white rounded-lg bg-green-500 border-l-4 border-green-700 shadow-md">
        <p>{{ session('success') ?? '' }}</p>
    </div>
    <div class="mb-4 text-white rounded-lg bg-red-500 border-l-4 border-red-700 shadow-md">
        <p>{{ session('error') ?? '' }}</p>
    </div>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto space-y-4">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="mb-8 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-800">Edit Event</h1>
                    <a href="{{ route('event.show', $event->id) }}"
                        class="text-blue-600 hover:text-blue-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Event
                    </a>
                </div>
                <form method="POST" action="{{ route('event.update') }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" value="{{ $event->id }}">
                    <div class="mb-6">
                        <label for="event-title" class="block text-sm font-medium text-gray-700 mb-1">Event
                            Title</label>
                        <input type="text" id="event-title" name="title"
                            class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                            value="{{ $event->title }}" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="event-date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="datetime-local" id="event-date" name="begin_at"
                                class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                value="{{ $event->begin_at }}" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="event-location"
                            class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" id="event-location" name="location"
                            class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                            value="{{ $event->location }}" required>
                    </div>

                    <div class="mb-6">
                        <label for="event-category"
                            class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select id="event-category" name="category_id"
                            class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                            required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if ($category->id == $event->category->id) @selected(true) @endif>
                                    {{ $category->category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="max-participants" class="block text-sm font-medium text-gray-700 mb-1">Maximum
                            Participants</label>
                        <input type="number" id="max-participants" name="max_participants" min="1"
                            class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                            value="{{ $event->max_participants }}" required>
                    </div>

                    <div class="mb-8">
                        <label for="event-description"
                            class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="event-description" name="description" rows="6"
                            class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                            required>{{ $event->description }}</textarea>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('profile') }}">
                            <button type="button"
                                class="px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition duration-300">Discard
                                Changes</button>
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition duration-300">Save
                            Changes</button>
                    </div>
                </form>
            </div>
            <div class="border border-red-200 rounded-lg p-6 mb-8 bg-white">
                <h3 class="text-red-600 font-medium mb-4">Danger Zone</h3>
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div>
                        <h4 class="text-gray-800 font-medium">Cancel Event</h4>
                        <p class="text-gray-500 text-sm">Registered participants will be notified</p>
                    </div>
                    <form action="{{ route('event.softDelete', ['id' => $event->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="mt-3 sm:mt-0 px-4 py-2 bg-white border border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition duration-300">Cancel
                            Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
