<div>
    <div>
        <form wire:submit.prevent="postTweet">
            <div class="w-full my-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                <div class="flex items-center justify-between px-3 py-2 border-b dark:border-gray-600">
                    <div class="flex flex-wrap items-center divide-gray-200 sm:divide-x sm:rtl:divide-x-reverse dark:divide-gray-600">
                        <div class="flex items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                            
                            <button type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <input wire:model.live="text_color" id="colorPicker" type="color" class="w-5 h-5 cursor-pointer border-0 p-0 m-0 r" style="appearance: none;">
                                <span class="sr-only">Text color</span>
                            </button>
                            <button type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <input wire:model.live="background_color" id="colorPicker" type="color" class="w-5 h-5 cursor-pointer border-0 p-0 m-0 r" style="appearance: none;">
                                <span class="sr-only">Background color</span>
                            </button>
                            <button type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM13.5 6a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm-7 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm3.5 9.5A5.5 5.5 0 0 1 4.6 11h10.81A5.5 5.5 0 0 1 10 15.5Z"/>
                                </svg>
                                <span class="sr-only">Add emoji</span>
                            </button>

                        </div>
                    </div>
                    <div id="tooltip-fullscreen" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Show full screen
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
                <div x-data="{ texto: '' }" style="background: {{ $background_color }}" class="relative px-4 py-2 bg-white rounded-b-lg dark:bg-gray-800">
                    <label for="editor" class="sr-only">Publish post</label>
                    <textarea id="editor" style="color: {{ $text_color }}; background: {{ $background_color }}" x-model="texto" wire:model.live='content' rows="8" class="block w-full px-0 text-sm text-gray-800 border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Whats happening? " required /></textarea>

                    <span style="color: {{ $text_color }}" class="absolute bottom-2">-<span x-text="500 - texto.length" class="error"></span></span>
                    @error('content')
                        <span class="error"></span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-purple-600 rounded-lg focus:ring-4 focus:ring-purple-200 dark:focus:ring-purple-900 hover:bg-purple-800">
                Publish post
            </button>
        </form>
    </div>
</div>
