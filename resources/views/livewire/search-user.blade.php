<div class="flex flex-col">
    <input 
        type="text" 
        wire:model.live.debounce.150ms="query" 
        placeholder="Pesquise por usuários"
        class="h-6"
    >
    <div class="">
        @foreach ($users as $user)
            <a href="{{ route("users.show", ["username" => $user['name']]) }}">
                <option value="{{ $user['name'] }}">{{ $user['name'] }}</option>
            </a>
        @endforeach
    </div>
</div>
