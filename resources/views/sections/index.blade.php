<x-app-layout>
    <x-slot name="header">
        {{ $course->course_title }}
    </x-slot>
    <div class="max-w-7xl mx-auto space-y-2">
        <div class="grid grid-cols-2 gap-2">
            <x-card>
                <h1>Add Section</h1>
                <form method="POST" action="{{ route('addSection', $course) }}">
                    @csrf
                    <!-- Section Name -->
                    <div>
                        <x-input-label for="section_name" :value="__('Section Name')" />
                        <x-text-input id="section_name" type="text" name="section_name" :value="old('section_name')" autofocus
                            autocomplete="section_name" />
                        <x-input-error :messages="$errors->get('section_name')" />
                    </div>
                    <!-- Year Level -->
                    <div>
                        <x-input-label for="year_level" :value="__('Year Level')" />
                        <x-text-input id="year_level" type="text" name="year_level" :value="old('year_level')" autofocus
                            autocomplete="year_level" />
                        <x-input-error :messages="$errors->get('year_level')" />
                    </div>
                    <div class="flex items-center justify-end mt-2 gap-2">
                        @if (session('status') === 'section-stored')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                                {{ __('Saved') }}
                            </p>
                        @endif
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </x-card>
            <x-card>
                <h1>Sections</h1>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Year Level
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($course->sections as $section)
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        {{ $section->section_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $section->year_level }}
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
