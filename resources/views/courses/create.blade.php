<x-app-layout>
    <x-slot name="header">
        {{ __('Create Course') }}
    </x-slot>
    <div class="max-w-7xl mx-auto">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form method="POST" action="{{ route('courses.store') }}">
                @csrf
                <!-- Title -->
                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" type="text" name="title" :value="old('title')" autofocus
                        autocomplete="title" />
                    <x-input-error :messages="$errors->get('title')" />
                </div>
                <!-- Abbrev -->
                <div>
                    <x-input-label for="abbrev" :value="__('Abbreviation')" />
                    <x-text-input id="abbrev" type="text" name="abbrev" :value="old('abbrev')" autofocus
                        autocomplete="abbrev" />
                    <x-input-error :messages="$errors->get('abbrev')" />
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                    @if (session('status') === 'course-stored')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
