<div>

    @auth
        <div 
            x-data="{ select: false }" 
            class="my-6 relative w-full mt-4 rounded-md border h-10 p-1 bg-gray-200"
        >
            <div class="relative w-full h-full flex items-center">
                <div @click="select = !select; $wire.updateIsAllTweets(0)" class="w-full flex justify-center text-gray-400 cursor-pointer">
                    <button>Usuários que você segue</button>
                </div>
                <div @click="select = !select; $wire.updateIsAllTweets(1)" class="w-full flex justify-center text-gray-400 cursor-pointer">
                    <button>Todos os usuários</button>
                </div>
            </div>

            <span 
                :class="{ 'left-1/2 -ml-1 text-gray-800':select, 'left-1 text-purple-600 font-semibold':!select }"
                x-text="!select ? 'Seguindo' : 'Todos'"
                class="bg-white shadow text-sm flex items-center justify-center w-1/2 rounded h-[1.88rem] transition-all duration-150 ease-linear top-[4px] absolute">
            </span>
        </div>
    @endauth
    
    <ul class="space-y-4">  
        @forelse ($tweets as $tweet) 
            <li wire:key="tweet-{{ $tweet->id }}" style="background: {{ $tweet->background_color }}" class="p-4 rounded-lg shadow">
                <div class="relative flex items-start space-x-4">
                    <a href="{{ route('users.show', ['username' => $tweet->user->name]) }}">
                        <img src="{{ $tweet->user->img_url }}" alt="profile" class="w-10 h-10 rounded-full">
                    </a>
                    @can('delete', $tweet)
                        <button wire:click='deleteTweet({{ $tweet->id }})' class="absolute right-0">
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
                        <a href="{{ route('users.show', ['username' => $tweet->user->name]) }}">
                            <h4 style="color: {{ $tweet->text_color }}" class="font-semibold">{{ $tweet->user->name }}</h4>
                        </a>
                        <p style="color: {{ $tweet->text_color }}" class="text-sm text-gray-600 font-light">{{ $tweet->created_at->diffForHumans() }}</p>
                        <div style="color: {{ $tweet->text_color }}" class="markdown-tailwind-parser mt-2">
                            @markdown{{ $tweet->content }}@endmarkdown
                        </div>
                        @auth
                            @livewire('like-tweet', ['tweet' => $tweet], key('tweet-'.$tweet->id))
                        @endauth
                    </div>
                </div>
            </li>
        @empty
            <p>No tweets here!</p>
        @endforelse
    </ul>
</div>
