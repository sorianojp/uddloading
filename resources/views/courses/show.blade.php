<x-app-layout>
    <x-slot name="header">
        {{ $course->title }}
    </x-slot>
    <div class="max-w-3xl mx-auto">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" x-data="{ show: false }">
            <!-- Content -->
            <div x-show="!show">
                <h1>{{ $course->title }}</h1>
                <h1>{{ $course->abbrev }}</h1>
            </div>
            <!-- Edit Button -->
            <div class="flex items-center justify-end mt-2 gap-2">
                @if (session('status') === 'course-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">{{ __('Saved') }}</p>
                @endif
                <x-primary-button @click="show = true" x-show="!show">Edit</x-primary-button>
            </div>
            <!-- Edit Form -->
            <div x-show="show">
                <!-- Edit From -->
                <form action="{{ route('courses.update', $course) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" type="text" name="title" :value="old('title', $course->title)" autofocus
                            autocomplete="title" />
                        <x-input-error :messages="$errors->get('title')" />
                    </div>
                    <!-- Abbrev -->
                    <div>
                        <x-input-label for="abbrev" :value="__('Abbreviation')" />
                        <x-text-input id="abbrev" type="text" name="abbrev" :value="old('abbrev', $course->abbrev)" autofocus
                            autocomplete="abbrev" />
                        <x-input-error :messages="$errors->get('abbrev')" />
                    </div>
                    <div class="flex items-center justify-end mt-2 gap-2">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                        <x-secondary-button @click="show = false">Cancel</x-secondary-button>
                    </div>
                </form>
            </div>
        </div>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div>
                <h1>Add Subject</h1>
                <form method="POST" action="{{ route('addSubject', $course) }}">
                    @csrf
                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" type="text" name="title" :value="old('title')" autofocus
                            autocomplete="title" />
                        <x-input-error :messages="$errors->get('title')" />
                    </div>
                    <!-- Subject Code -->
                    <div>
                        <x-input-label for="subject_code" :value="__('Abbreviation')" />
                        <x-text-input id="subject_code" type="text" name="subject_code" :value="old('subject_code')" autofocus
                            autocomplete="subject_code" />
                        <x-input-error :messages="$errors->get('subject_code')" />
                    </div>
                    <div class="flex items-center justify-end mt-2 gap-2">
                        @if (session('status') === 'subject-stored')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                                {{ __('Saved') }}
                            </p>
                        @endif
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
            <div>
                <div class="flex items-center gap-4">
                    <h1>Subjects</h1>
                </div>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Subject Code
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($course->subjects as $subject)
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        {{ $subject->title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $subject->subject_code }}
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
            </div>
        </div>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div>
                <h1>Add Section</h1>
                <form method="POST" action="{{ route('addSection', $course) }}">
                    @csrf
                    <!-- Year Level -->
                    <div>
                        <x-input-label for="year_level" :value="__('Year Level')" />
                        <x-text-input id="year_level" type="text" name="year_level" :value="old('year_level')" autofocus
                            autocomplete="year_level" />
                        <x-input-error :messages="$errors->get('year_level')" />
                    </div>
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" type="text" name="name" :value="old('name')" autofocus
                            autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" />
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
            </div>
            <div>
                <div class="flex items-center gap-4">
                    <h1>Sections</h1>
                </div>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Year Level
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($course->sections as $section)
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        {{ $section->year_level }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $section->name }}
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
            </div>
        </div>
    </div>
</x-app-layout>
