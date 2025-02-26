<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit an alert') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <form method="post" action="{{ route('alerts.update', $alert->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')
                
                        <div>
                            <x-label for="type" :value="__('Type')" />
                            
                            <select id="type" name="type" class="mt-1 block w-full" required>
                                <option value="warning" {{ $alert->type == 'warning' ? 'selected' : '' }}>Warning</option>
                                <option value="deprecation" {{ $alert->type == 'deprecation' ? 'selected' : '' }}>Deprecation notice</option>
                                <option value="info" {{ $alert->type == 'info' ? 'selected' : '' }}>Information</option>
                            </select>

                            <x-input-error class="mt-2" :for="$errors->get('type')" />
                        </div>

                        <div>
                            <x-label for="message" :value="__('Message')" />
                            
                            <input type="text" id="message" name="message" class="mt-1 block w-full" value="{{ $alert->message }}" required>
                            
                            <x-input-error class="mt-2" :for="$errors->get('message')" />
                        </div>

                        <div>
                            <x-label for="active" :value="__('Active')" />
                            
                            <input type="checkbox" id="active" name="active" class="mt-1 block" {{ $alert->active ? 'checked' : '' }}>
                            
                            <x-input-error class="mt-2" :for="$errors->get('active')" />
                        </div>
                
                        <div class="flex items-center gap-4">
                            <x-button>{{ __('Update') }}</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
