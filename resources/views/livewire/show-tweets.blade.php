<div>
    {{-- Do your work, then step back. --}}
    <ul class="space-y-4">  
        @forelse ($tweets as $tweet) 
            <li style="background: {{ $tweet->background_color }}" class="p-4 rounded-lg shadow">
                <div class="relative flex items-start space-x-4">
                    <img src="{{ $tweet->user->img_url }}" alt="{{ $tweet->user->name }}" class="w-10 h-10 rounded-full">
                    @can('delete', $tweet)
                        <button wire:click='deleteTweet({{$tweet->id}})' class="absolute right-0">
                            <lord-icon
                                src="https://cdn.lordicon.com/hbwlzuqx.json"
                                trigger="hover"
                                stroke="bold"
                                state="hover-pinch"
                                colors="primary:{{ $tweet->text_color }}"
                                style="width:30px;height:30px">
                            </lord-icon>
                        </button>
                    @endcan
                    <div>
                        <h4 style="color: {{ $tweet->text_color }}" class="font-semibold">{{ $tweet->user->name }}</h4>
                        <p style="color: {{ $tweet->text_color }}" class="text-sm text-gray-600 font-light">{{ $tweet->created_at->diffForHumans() }}</p>
                        <div style="color: {{ $tweet->text_color }}" class="markdown-tailwind-parser mt-2">
                            @markdown{{ $tweet->content }}@endmarkdown
                        </div>
                        @auth
                            <div
                                style="color: {{ $tweet->text_color }}" 
                                class="mt-2 italic flex flex-row items-center cursor-pointer"
                                x-data="{ clicked: false, likes: 10 }"
                                x-on:click="clicked = !clicked; $wire.test(clicked);"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" 
                                    :style="clicked ? 'fill: {{ $tweet->text_color }};' : 'stroke: {{ $tweet->text_color }};'"
                                    class="w-5 h-5 mr-1 -mt-px"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                <p><span x-text="likes + clicked"></span> Likes</p>
                            </div>
                        @endauth
                    </div>
                </div>
            </li>
        @empty
            <p>No tweets here!</p>
        @endforelse
    </ul>
</div>
