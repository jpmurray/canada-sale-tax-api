<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Propose a Rate Update') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            {{ __('Your rate update proposal will be reviewed by an administrator before being published.') }}
                        </p>
                    </div>

                    <form method="post" action="{{ route('pending-rate-updates.store') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('post')
                
                        <div>
                            <x-label for="province" :value="__('Province')" />
                            
                            <select id="province" name="province" class="mt-1 block w-full" required>
                                <option value="FE">Federal</option>
                                <option value="AB">Alberta</option>
                                <option value="BC">British Columbia</option>
                                <option value="MB">Manitoba</option>
                                <option value="NB">New Brunswick</option>
                                <option value="NL">Newfoundland and Labrador</option>
                                <option value="NS">Nova Scotia</option>
                                <option value="ON">Ontario</option>
                                <option value="PE">Prince Edward Island</option>
                                <option value="QC">Quebec</option>
                                <option value="SK">Saskatchewan</option>
                                <option value="NT">Northwest Territories</option>
                                <option value="NU">Nunavut</option>
                                <option value="YT">Yukon</option>
                            </select>

                            <x-input-error class="mt-2" :for="$errors->get('province')" />
                        </div>

                        <div>
                            <x-label for="start" :value="__('Start Date')" />
                            
                            <input type="date" id="start" name="start" class="mt-1 block w-full" required>
                            
                            <x-input-error class="mt-2" :for="$errors->get('start')" />
                        </div>

                        <div>
                            <x-label for="pst" :value="__('Provincial Sale Tax (PST)')" />
                            
                            <input type="number" id="pst" name="pst" step="0.00001" class="mt-1 block w-full" required>
                            
                            <x-input-error class="mt-2" :for="$errors->get('pst')" />
                        </div>

                        <div>
                            <x-label for="gst" :value="__('Goods and Services Tax (GST)')" />
                            
                            <input type="number" id="gst" name="gst" step="0.00001" class="mt-1 block w-full" required>
                            
                            <x-input-error class="mt-2" :for="$errors->get('gst')" />
                        </div>

                        <div>
                            <x-label for="hst" :value="__('Harmonized Sale Tax (HST)')" />
                            
                            <input type="number" id="hst" name="hst" step="0.00001" class="mt-1 block w-full" required>
                            
                            <x-input-error class="mt-2" :for="$errors->get('hst')" />
                        </div>

                        <div>
                            <x-label for="applicable" :value="__('Applicable tax rate')" />
                            
                            <input type="number" id="applicable" name="applicable" step="0.00001" class="mt-1 block w-full" required>
                            
                            <x-input-error class="mt-2" :for="$errors->get('applicable')" />
                        </div>

                        <div>
                            <x-label for="type" :value="__('Types used for the type tax rate (comma separated)')" />
                            
                            <input type="text" id="type" name="type" class="mt-1 block w-full" required>
                            
                            <x-input-error class="mt-2" :for="$errors->get('type')" />
                        </div>

                        <div>
                            <x-label for="source" :value="__('Source')" />
                            
                            <input type="text" id="source" name="source" class="mt-1 block w-full" required>
                            
                            <x-input-error class="mt-2" :for="$errors->get('source')" />
                        </div>
                
                        <div class="flex items-center gap-4">
                            <x-button>{{ __('Submit Proposal') }}</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
