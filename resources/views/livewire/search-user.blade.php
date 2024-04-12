<div class="max-sm:w-[75%] flex flex-col">
    <input 
        type="text" 
        wire:model.live.debounce.150ms="query" 
        placeholder="Pesquise por usuários"
        class="h-6 py-6 rounded-full"
    >
    @if ($users)
        <div class="p-4 mt-2 flex flex-col gap-y-3 rounded-xl bg-white border border-gray-600">
            @foreach ($users as $user)
                <div class="flex flex-row w-full items-center">
                    <img class="h-8 rounded-full" src="{{ $user['img_url'] }}" alt="{{ $user['name'] }}">
                    <a class="ml-2" href="{{ route("users.show", ["username" => $user['name']]) }}">
                        <option value="{{ $user['name'] }}">{{ $user['name'] }}</option>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
