@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="max-w-[65%] mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div 
                style="background: url({{ $user->background_url }})" 
                class="sm:flex sm:items-center px-6 py-8 bg-cover">
                <img class="block sm:mx-0 sm:flex-shrink-0 h-16 sm:h-24 rounded-full" src="{{ $user->img_url }}" alt="Imagem de Perfil">
                <div class="ml-4 mt-4 sm:mt-0 sm:ml-4 text-center sm:text-left ">
                    <p class="text-xl leading-tight">{{ $user->name }}</p>
                    <p class="text-sm leading-tight text-gray-600">{{ $user->bio }}</p>
                    <div class="mt-4">
                        @authusercan($user->id)   
                            <button class="text-purple-600 text-sm font-semibold rounded-full border border-purple-600 hover:text-white hover:bg-purple-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2 focus:ring-offset-purple-200 transition ease-in duration-300 px-4 py-1">Config</button>
                        @elseauthusercan
                            <button class="text-purple-600 text-sm font-semibold rounded-full border border-purple-600 hover:text-white hover:bg-purple-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2 focus:ring-offset-purple-200 transition ease-in duration-300 px-4 py-1">Follow</button>
                        @endauthusercan
                    </div>
                </div>
            </div>
            @auth
                <div class="px-6 py-4">
                    @authusercan($user->id)   
                        <h3 class="font-bold text-xl mb-2 mt-4">Fazer Post</h3>
                        @livewire('post-tweet')
                    @endauthusercan
                </div>
            @endauth
            <div class="px-6 pt-2 pb-10">
                <h3 class="font-bold text-xl mb-2 mt-4">Last posts</h3>
                <div class="text-gray-700 text-base">
                    <livewire:show-tweets :user="$user" />
                </div>
            </div>
        </div>
    </div>
@endsection