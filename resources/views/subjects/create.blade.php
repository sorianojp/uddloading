<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subjects') }}
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form method="POST" action="{{ route('subjects.store') }}">
                    @csrf
                    <!-- Code -->
                    <div>
                        <x-input-label for="code" :value="__('Code')" />
                        <x-text-input id="code" class="block mt-1 w-full" type="text" name="code"
                            :value="old('code')" autofocus autocomplete="code" />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>
                    <!-- Code -->
                    <div>
                        <x-input-label for="subject" :value="__('Subject')" />
                        <x-text-input id="subject" class="block mt-1 w-full" type="text" name="subject"
                            :value="old('subject')" autofocus autocomplete="subject" />
                        <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                    </div>
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                        @if (session('status') === 'subject-stored')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
