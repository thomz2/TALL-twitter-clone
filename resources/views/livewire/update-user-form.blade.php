<div class="max-w-[65%] mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
    <form 
        class="flex flex-col gap-2"
        method="post"
        action="{{ route('users.edit') }}"
    >
        @csrf
        <div 
            class="relative h-60 bg-top bg-cover"
            style="background-image: url({{ $user->background_url }})" 
        >
            <img class="absolute left-[50%] -translate-x-1/2 -bottom-12 h-16 sm:h-28 rounded-full" src="{{ $user->img_url }}" alt="Imagem de Perfil">
        </div>
        <div class="px-4 py-10 flex flex-col gap-2">
            <label for="">Novo nome</label>
            <input wire:model.live="name">
            <label for="">Novo email</label>
            <input wire:model.live="email">
            <label for="">Senha Nova</label>
            <input type="password">
            <label for="confirm_password">Confirme a Senha</label>
            <input type="password">
            <button 
                class="self-center mt-6 py-2 w-[30%] text-purple-600 text-sm font-semibold rounded-full border border-purple-600 hover:text-white hover:bg-purple-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2 focus:ring-offset-purple-200 transition ease-in duration-300 px-4 py-1"
                type="submit"
            >
                Salvar
            </button>
        </div>
    </form>
</div>