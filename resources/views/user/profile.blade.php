@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="max-w-[65%] mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div 
                style="background-image: url({{ $user->background_url }})" 
                class="relative sm:flex sm:items-center px-6 py-8 bg-cover"
            >
                <img class="block sm:mx-0 sm:flex-shrink-0 h-16 sm:h-24 rounded-full" src="{{ $user->img_url }}" alt="Imagem de Perfil">
                <div class="ml-4 mt-4 sm:mt-0 sm:ml-4 text-center sm:text-left ">
                    <p class="text-xl leading-tight">{{ $user->name }}</p>
                    <p class="text-sm leading-tight text-gray-600">{{ $user->bio }}</p>
                    @livewire('follow-tab', ['user' => $user])
                </div>
                @authusercan($user->id)   
                    <div class="absolute top-5 right-6">
                        <a href="{{ route('users.form', ['username' => $user->name]) }}">
                            Config
                        </a>
                    </div>
                @endauthusercan
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