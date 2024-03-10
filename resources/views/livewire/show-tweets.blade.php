<div>
    {{-- Do your work, then step back. --}}
    <ul class="space-y-4">  
        @forelse ($tweets as $tweet) 
            <li style="background: white" class="p-4 rounded-lg shadow">
                <div class="relative flex items-start space-x-4">
                    {{-- <img src="{{ $tweet->user->profile_photo_url }}" alt="{{ $tweet->user->name }}" class="w-10 h-10 rounded-full"> --}}
                    @can('delete', $tweet)
                        <button wire:click='deleteTweet({{$tweet->id}})' class="absolute right-0">
                            {{-- <lord-icon
                                src="https://cdn.lordicon.com/hbwlzuqx.json"
                                trigger="hover"
                                stroke="bold"
                                state="hover-pinch"
                                colors="primary:#a866ee"
                                style="width:30px;height:30px">
                            </lord-icon> --}}
                        </button>
                    @endcan
                    <div class="relative">
                        <h4 class="font-semibold">{{ $tweet->user->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $tweet->created_at->diffForHumans() }}</p>
                        <div style="color: black" class="custom-titles">
                            @markdown{{ $tweet->content }}@endmarkdown
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <p>No tweets here!</p>
        @endforelse
    </ul>
</div>
