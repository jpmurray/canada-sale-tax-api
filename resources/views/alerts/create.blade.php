<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add an alert') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <form method="post" action="{{ route('alerts.store') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('post')
                
                        <div>
                            <x-label for="type" :value="__('Type')" />
                            
                            <select id="type" name="type" class="mt-1 block w-full" required>
                                <option value="warning">Warning</option>
                                <option value="deprecation">Deprecation notice</option>
                                <option value="info">Information</option>
                            </select>

                            <x-input-error class="mt-2" :for="$errors->get('type')" />
                        </div>

                        <div>
                            <x-label for="message" :value="__('Message')" />
                            
                            <input type="text" id="message" name="message" class="mt-1 block w-full" required>
                            
                            <x-input-error class="mt-2" :for="$errors->get('message')" />
                        </div>

                        <div>
                            <x-label for="active" :value="__('Active')" />
                            
                            <input type="checkbox" id="active" name="active" class="mt-1 block">
                            
                            <x-input-error class="mt-2" :for="$errors->get('active')" />
                        </div>
                
                        <div class="flex items-center gap-4">
                            <x-button>{{ __('Add') }}</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
