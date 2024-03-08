<div>
    {{-- Do your work, then step back. --}}
    <ul class="space-y-4">  
        @forelse ($tweets as $tweet) 
            <li class="p-4 bg-white rounded-lg shadow">
                <div class="relative flex items-start space-x-4">
                    {{-- <img src="{{ $tweet->user->profile_photo_url }}" alt="{{ $tweet->user->name }}" class="w-10 h-10 rounded-full"> --}}
                    @can('delete', $tweet)
                        <button wire:click='deleteTweet({{$tweet->id}})' class="absolute right-4">Remove</button>
                    @endcan
                    <div class="relative">
                        <h4 class="font-semibold">{{ $tweet->user->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $tweet->created_at->diffForHumans() }}</p>
                        <div class="not-tailwind">

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
