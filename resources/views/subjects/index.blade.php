<x-app-layout>
    <x-slot name="header">
        {{ $course->course_title }}
    </x-slot>
    <div class="max-w-7xl mx-auto space-y-2">
        <div class="grid grid-cols-2 gap-2">
            <x-card>
                <h1>Add Subject</h1>
                <form method="POST" action="{{ route('addSubject', $course) }}">
                    @csrf
                    <!-- Subject Name -->
                    <div>
                        <x-input-label for="subject_name" :value="__('Subject Name')" />
                        <x-text-input id="subject_name" type="text" name="subject_name" :value="old('subject_name')" autofocus
                            autocomplete="subject_name" />
                        <x-input-error :messages="$errors->get('subject_name')" />
                    </div>
                    <!-- Subject Code -->
                    <div>
                        <x-input-label for="subject_code" :value="__('Subject Code')" />
                        <x-text-input id="subject_code" type="text" name="subject_code" :value="old('subject_code')" autofocus
                            autocomplete="subject_code" />
                        <x-input-error :messages="$errors->get('subject_code')" />
                    </div>
                    <!-- Lecture -->
                    <div>
                        <x-input-label for="lec" :value="__('Lecture')" />
                        <x-text-input id="lec" type="number" name="lec" :value="old('lec')" step="0.0"
                            autofocus autocomplete="lec" />
                        <x-input-error :messages="$errors->get('lec')" />
                    </div>
                    <!-- Laboratory -->
                    <div>
                        <x-input-label for="lab" :value="__('Laboratory')" />
                        <x-text-input id="lab" type="number" name="lab" :value="old('lab')" autofocus
                            autocomplete="lab" />
                        <x-input-error :messages="$errors->get('lab')" />
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
            </x-card>
            <x-card>
                <h1>Subjects</h1>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Subject Code
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Lec/Lab
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($course->subjects as $subject)
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        {{ $subject->subject_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $subject->subject_code }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $subject->lec }}/ {{ $subject->lab }}
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
