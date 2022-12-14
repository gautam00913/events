<div class="{{ $event->premium ? 'bg-yellow-600' : 'bg-white' }} rounded-lg shadow-md hover:shadow-xl p-3">
    <div class="flex space-x-5">
        <div class="flex space-x-3 flex-start">
            <div class="leading-none">
                <p class="text-gray-500 pb-2 mb-2 border-b border-gray-200">{{ $event->starts_at->translatedFormat('M') }}</p>
                <p class="text-gray-800 font-medium title-font text-lg leading-none">{{ $event->starts_at->translatedFormat('d') }}</p>
            </div>
            <div class="leading-none">
                <p class="text-gray-500 pb-2 mb-2 border-b border-gray-200">{{ $event->ends_at->translatedFormat('M') }}</p>
                <p class="text-gray-800 font-medium title-font text-lg leading-none">{{ $event->ends_at->translatedFormat('d') }}</p>
            </div>
        </div>
        <div>
            <h3 class="title-font text-xs tracking-widset text-indigo-500 inline-block mb-1">
                @foreach ($event->tags as $tag)
                    {{ $tag->name }}{{ $loop->last ? '': ',' }}
                @endforeach
            </h3>
            <h2 class="text-lg md:text-xl font-bold text-gray-700 title-font mb-3">{{ $event->title }}</h2>
            <div class="leading-relaxed mb-5">
                {{ $event->content }}
            </div>
            <a class="inline-flex items-center "href="#">
                <img src="https://th.bing.com/th/id/OIF.B8K6TPe1WeyJKZZKCx1oPg?w=185&h=185&c=7&r=0&o=5&pid=1.7" class="w-8 h-8 rounded-full object-center object-cover flex-shrink-0" alt="...">
                <span class="flex flex-grow flex-col pl-6">
                    <span class="title-font font-medium text-gray-900 italic">
                        {{ $event->user->name }}
                    </span>
                </span>
            </a>
        </div>
    </div>
</div>