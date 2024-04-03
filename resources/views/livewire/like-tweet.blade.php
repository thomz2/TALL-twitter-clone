<div
    style="color: {{ $tweet->text_color }}" 
    class="mt-2 italic flex flex-row items-center cursor-pointer"
    x-data="{ isLiked: @entangle('isLiked') }"
    x-on:click.prevent="isLiked = !isLiked; $wire.likeOrDislikeTweet(isLiked, {{ $tweet->id }})"
>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" 
        :style="isLiked ? 'fill: {{ $tweet->text_color }};' : 'stroke: {{ $tweet->text_color }};'"
        class="w-5 h-5 mr-1 -mt-px"
    >
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
    </svg>
    <p><span x-text='$wire.countOfLikes'></span>  Likes</p>
</div>