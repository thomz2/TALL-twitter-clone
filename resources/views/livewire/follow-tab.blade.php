<div class="mt-4">
    <div class="grid grid-cols-3 gap-4">
        <div class="text-center">
            <p>{{ $this->user->tweets()->count() }}</p>
            <p class="mt-1 text-gray-500 text-xs font-bold uppercase">mdweets</p>
        </div>
        <div class="text-center">
            <p x-text='$wire.followers'></p>
            <p class="mt-1 text-gray-500 text-xs font-bold uppercase">followers</p>
        </div>
        <div class="text-center">
            <p>{{ $this->following }}</p>
            <p class="mt-1 text-gray-500 text-xs font-bold uppercase">following</p>
        </div>
    </div>
    @auth
    <div class="mt-4"> 
        @authusercan($user->id)   
            <button class="w-full text-purple-600 text-sm font-semibold rounded-full border border-purple-600 hover:text-white hover:bg-purple-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2 focus:ring-offset-purple-200 transition ease-in duration-300 px-4 py-1">Config</button>
        @elseauthusercan
            <button 
                class="w-full text-purple-600 text-sm font-semibold rounded-full border border-purple-600 hover:text-white hover:bg-purple-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2 focus:ring-offset-purple-200 transition ease-in duration-300 px-4 py-1"
                x-data="{ isFollowed: @entangle('isFollowed') }"
                x-text="isFollowed ? 'Unfollow' : 'Follow'"
                x-on:click="isFollowed = !isFollowed; $wire.followOrUnfollowUser()"
            ></button>
        @endauthusercan
    </div>
    @endauth
</div>
