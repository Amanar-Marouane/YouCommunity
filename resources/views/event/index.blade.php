<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouCommunity - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-900 font-['Inter']">
    <x-header></x-header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <section class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white mb-4">Discover Local Events</h1>
            <p class="text-gray-400 mb-8">Find and join community events happening near you</p>
            <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">Create Event</button>
        </section>

        <section class="mb-12">
            <div class="bg-gray-800 p-4 rounded-lg">
                <div class="flex gap-4">
                    <input type="text" id="search-input" placeholder="Search events..."
                        class="flex-1 bg-gray-700 text-white px-4 py-2 rounded-md">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Search</button>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
                <div class="bg-gray-800 rounded-lg overflow-hidden events-card">
                    <div class="p-6">
                        <p class="text-blue-400 text-sm mb-2 event-category">{{ $event->category->category }}</p>
                        <form action="{{ route('event.show') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $event->id }}">
                            <button type="submit">
                                <h3 class="text-white text-xl font-semibold mb-2 event-title">{{ $event->title }}</h3>
                            </button>
                        </form>
                        <p class="text-gray-400 mb-4 event-description">{{ $event->description }}</p>
                        <div>
                            <span class="text-gray-400 block event-date">{{ $event->begin_at }}</span>
                            @unless ($event->creator_id == Auth::id())
                                <button
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mt-12">RSVP</button>
                            @else
                                <div class="mt-4 flex items-center p-4 bg-gray-700 rounded-lg border border-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-gray-300 font-medium">You can manage this event from your dashboard</p>
                                </div>
                            @endunless
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    </main>
</body>

</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function is_include(element, target) {
            return element.innerText.toLowerCase().includes(target.toLowerCase());
        }

        let searchInput = document.querySelector("#search-input");
        searchInput.addEventListener("input", () => {
            let target = searchInput.value.trim();
            let eventsCard = document.querySelectorAll(".events-card");

            eventsCard.forEach(element => {
                if (target === "") {
                    element.style.display = "";
                } else {
                    category = is_include(element.querySelector(".event-category"), target);
                    title = is_include(element.querySelector(".event-title"), target);
                    description = is_include(element.querySelector(".event-description"),
                        target);
                    date = is_include(element.querySelector(".event-date"), target);
                    if (title || category || description || date) element.style.display = "";
                    else element.style.display = "none";
                }
            });
        })
    })
</script>
