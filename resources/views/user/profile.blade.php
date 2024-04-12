@extends('layouts.app')

@section('content')
    <div class="">
        <a href="{{ route('home') }}" class="text-gray-400 z-10 fixed top-2 left-2">
            Voltar
        </a>
        <div class="mx-auto bg-slate-200 min-h-screen overflow-hidden">
            <div 
                style="background-image: url({{ $user->background_url }})" 
                class="relative sm:flex sm:items-center px-6 py-32 bg-cover bg-top"
            >
                <img class="absolute left-[50%] -translate-x-1/2 -bottom-12 h-28 rounded-full" src="{{ $user->img_url }}" alt="Imagem de Perfil">
            </div>
            <div class="w-full flex flex-col justify-center items-center bg-slate-200 dark:bg-neutral-800">
                <div class="pt-10 mt-4 text-center">
                    <p class="text-xl leading-tight">{{ $user->name }}</p>
                    <p class="text-sm leading-tight text-gray-600">{{ $user->bio }}</p>
                    @livewire('follow-tab', ['user' => $user])
                </div>

                <div class="w-full sm:w-[60%]">
                    @auth
                        <div class="px-6 py-4">
                            @authusercan($user->id)   
                                <h3 class="font-bold text-xl mt-4 -mb-2 text-neutral-800">Fazer Post</h3>
                                @livewire('post-tweet')
                            @endauthusercan
                        </div>
                    @endauth
                    <div class="px-6 pb-10">
                        <h3 class="font-bold text-xl mb-2 text-neutral-800">Últimos posts</h3>
                        <div class="text-gray-700 text-base">
                            <livewire:show-tweets :user="$user" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection