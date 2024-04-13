<div class="w-full min-h-screen h-screen bg-slate-200">
    <a href="{{ route('users.show', ['username' => $user->name]) }}" class="text-gray-400 z-10 fixed top-2 left-2">
        Perfil
    </a>
    <form 
        class="flex flex-col gap-2"
        wire:submit.prevent='updateUser'
    >
        @csrf
        <div 
            class="relative py-32 bg-top bg-cover"
            style="background-image: url({{ $user->background_url }})" 
        >
            <img class="absolute left-[50%] -translate-x-1/2 -bottom-12 h-28 rounded-full" src="{{ $user->img_url }}" alt="Imagem de Perfil">
        </div>
        <div class="px-4 py-10 flex flex-col gap-2 justify-center items-center">
            <div class="flex flex-col gap-2 w-full sm:w-[65%]">
                <label for="profile_img">Foto de Perfil</label>
                <input 
                    class="p-2 block w-full text-sm text-gray-900 border border-gray-300 cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                    wire:model.live="profile_img" 
                    accept="image/png, image/jpeg" 
                    type="file"
                >
                <p class="text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG ou JPEG.</p>
                @error('profile_img')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <label for="background_img">Background</label>
                <input 
                    class="p-2 block w-full text-sm text-gray-900 border border-gray-300 cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                    wire:model.live="background_img" 
                    accept="image/png, image/jpeg" 
                    type="file"
                >
                <p class="text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG ou JPEG.</p>
                @error('background_img')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <label for="name">Nome</label>
                <input wire:model.live="name">
                @error('name')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <label for="bio">Biografia</label>
                <input wire:model.live="bio">
                @error('bio')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <label for="email">Email</label>
                <input wire:model.live="email">
                @error('email')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <label for="password">Senha</label>
                <input wire:model.live="password" type="password">
                @error('password')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <label for="passwordConfirmation">Confirme a Senha</label>
                <input wire:model.live="passwordConfirmation" type="password">
                @error('passwordConfirmation')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <button 
                    class="self-center mt-6 py-2 w-full sm:w-[30%] text-purple-600 text-sm font-semibold rounded-full border border-purple-600 hover:text-white hover:bg-purple-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2 focus:ring-offset-purple-200 transition ease-in duration-300 px-4 py-1"
                    type="submit"
                >
                    Salvar
                </button>
            </div>
        </div>
    </form>
</div>