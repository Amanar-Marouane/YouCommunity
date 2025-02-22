<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <x-header></x-header>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-gray-900 text-white p-8 rounded-t-lg">
            <h1 class="text-3xl font-bold mb-4">{{ $event->title }}</h1>
            <div class="flex items-center space-x-4 text-gray-300">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Begin: {{ $event->begin_at }}
                </span>
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $event->location }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-4">About This Event</h2>
                    <p class="text-gray-600 mb-4">
                        {{ $event->description }}
                    </p>
                </div>
            </div>

            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Event Details</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <div>
                                    <p class="text-gray-600">Participants</p>
                                    <p class="font-semibold">
                                        {{ count($event->current_participants_count) }}/{{ $event->max_participants }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <div>
                                    <p class="text-gray-600">{{ $event->category->category }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <div>
                                    <p class="text-gray-600">Creator</p>
                                    <p class="font-semibold">{{ $event->user->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @auth
                        @if ($event->user_id != Auth::id())
                        @empty($event->is_reserved()->exists())
                            <form action="{{ route('event.reserve') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $event->id }}">
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                                    RSVP
                                </button>
                            </form>
                        @else
                            <form action="{{ route('event.cancel') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $event->id }}">
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                                    Cancel
                                </button>
                            </form>
                        @endempty
                    @else
                        <a href="/profile">
                            <button
                                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                                You can manage this event from your dashboard
                            </button>
                        </a>
                    @endif
                @else
                    <a href="/login">
                        <button
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                            Sign In First
                        </button>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-bold mb-6">Comments</h2>
            @auth
                <form class="mb-8" action="{{ route('comment.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <div class="mb-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Leave a
                            comment</label>
                        <textarea id="comment" rows="4" name="content"
                            class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                            placeholder="Share your thoughts about this event..."></textarea>
                    </div>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">Post
                        Comment</button>
                </form>
            @else
                <div class="bg-gray-50 p-6 rounded-lg mb-8 text-center">
                    <p class="text-gray-600 mb-4">Please sign in to leave a comment</p>
                    <a href="/login"
                        class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">Sign
                        In</a>
                </div>
            @endauth
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-6">
                    @if ($comments)
                        @foreach ($comments as $comment)
                            <div class="flex items-start mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-1">
                                        <h4 class="font-bold text-gray-800">{{ $comment->user->name }}</h4>
                                        <span class="text-sm text-gray-500">{{ $comment->formatted_date }}</span>
                                    </div>
                                    <p class="text-gray-600">{{ e($comment->content) }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
