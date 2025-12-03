<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Rate Update Proposal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                            {{ __('Submitted by: :name on :date', ['name' => $pendingUpdate->user->name, 'date' => $pendingUpdate->created_at->format('Y-m-d H:i')]) }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <x-label :value="__('Province')" />
                            <p class="mt-1 text-lg font-medium text-gray-900 dark:text-gray-100">{{ $pendingUpdate->province }}</p>
                        </div>

                        <div>
                            <x-label :value="__('Start Date')" />
                            <p class="mt-1 text-lg font-medium text-gray-900 dark:text-gray-100">{{ $pendingUpdate->start->format('Y-m-d') }}</p>
                        </div>

                        <div>
                            <x-label :value="__('Provincial Sale Tax (PST)')" />
                            <p class="mt-1 text-lg font-medium text-gray-900 dark:text-gray-100">{{ $pendingUpdate->pst }}</p>
                        </div>

                        <div>
                            <x-label :value="__('Goods and Services Tax (GST)')" />
                            <p class="mt-1 text-lg font-medium text-gray-900 dark:text-gray-100">{{ $pendingUpdate->gst }}</p>
                        </div>

                        <div>
                            <x-label :value="__('Harmonized Sale Tax (HST)')" />
                            <p class="mt-1 text-lg font-medium text-gray-900 dark:text-gray-100">{{ $pendingUpdate->hst }}</p>
                        </div>

                        <div>
                            <x-label :value="__('Applicable Tax Rate')" />
                            <p class="mt-1 text-lg font-medium text-gray-900 dark:text-gray-100">{{ $pendingUpdate->applicable }}</p>
                        </div>

                        <div>
                            <x-label :value="__('Type')" />
                            <p class="mt-1 text-lg font-medium text-gray-900 dark:text-gray-100">{{ $pendingUpdate->type }}</p>
                        </div>

                        <div>
                            <x-label :value="__('Source')" />
                            <p class="mt-1 text-lg font-medium text-gray-900 dark:text-gray-100">{{ $pendingUpdate->source }}</p>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-200 dark:border-gray-700">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Approve Form -->
                        <div class="p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                            <h3 class="text-lg font-medium text-green-800 dark:text-green-200 mb-4">{{ __('Approve') }}</h3>
                            <form method="post" action="{{ route('pending-rate-updates.approve', $pendingUpdate->id) }}">
                                @csrf
                                <div class="mb-4">
                                    <x-label for="approve_notes" :value="__('Notes (optional)')" />
                                    <textarea id="approve_notes" name="review_notes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="3"></textarea>
                                </div>
                                <x-button type="submit" class="bg-green-600 hover:bg-green-700">
                                    {{ __('Approve & Publish') }}
                                </x-button>
                            </form>
                        </div>

                        <!-- Reject Form -->
                        <div class="p-4 bg-red-50 dark:bg-red-900 rounded-lg">
                            <h3 class="text-lg font-medium text-red-800 dark:text-red-200 mb-4">{{ __('Reject') }}</h3>
                            <form method="post" action="{{ route('pending-rate-updates.reject', $pendingUpdate->id) }}">
                                @csrf
                                <div class="mb-4">
                                    <x-label for="reject_notes" :value="__('Reason for rejection (required)')" />
                                    <textarea id="reject_notes" name="review_notes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="3" required></textarea>
                                    <x-input-error class="mt-2" for="review_notes" />
                                </div>
                                <x-button type="submit" class="bg-red-600 hover:bg-red-700">
                                    {{ __('Reject') }}
                                </x-button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('pending-rate-updates.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            {{ __('← Back to Pending Updates') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
