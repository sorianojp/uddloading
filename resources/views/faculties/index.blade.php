<x-app-layout>
    <x-slot name="header">
        {{ __('Faculties') }}
    </x-slot>
    <div class="max-w-7xl mx-auto space-y-2">
        <div class="grid grid-cols-2 gap-2">
            <x-card>
                <h1>Add Faculty</h1>
                <form method="POST" action="{{ route('faculties.store') }}">
                    @csrf
                    <!-- Lastname -->
                    <div>
                        <x-input-label for="lastname" :value="__('Lastname')" />
                        <x-text-input id="lastname" type="text" name="lastname" :value="old('lastname')" autofocus
                            autocomplete="lastname" />
                        <x-input-error :messages="$errors->get('lastname')" />
                    </div>
                    <!-- Firstname -->
                    <div>
                        <x-input-label for="firstname" :value="__('Firstname')" />
                        <x-text-input id="firstname" type="text" name="firstname" :value="old('firstname')" autofocus
                            autocomplete="firstname" />
                        <x-input-error :messages="$errors->get('firstname')" />
                    </div>
                    <!-- Middlename -->
                    <div>
                        <x-input-label for="middlename" :value="__('Middlename')" />
                        <x-text-input id="middlename" type="text" name="middlename" :value="old('middlename')" autofocus
                            autocomplete="middlename" />
                        <x-input-error :messages="$errors->get('middlename')" />
                    </div>
                    <div class="flex items-center justify-end mt-2 gap-2">
                        @if (session('status') === 'faculty-stored')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                                {{ __('Saved') }}
                            </p>
                        @endif
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </x-card>
            <x-card>
                <h1>Faculties</h1>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($faculties as $faculty)
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        {{ $faculty->full_name }}
                                    </td>
                                </tr>
                            @empty
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-6 py-4" colspan="4">There are no data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
