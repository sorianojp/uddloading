<x-app-layout>
    <x-slot name="header">
        {{ __('Courses') }}
    </x-slot>
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-end mb-2">
            <a href="{{ route('courses.create') }}">
                <x-primary-button>
                    {{ __('Create') }}
                </x-primary-button>
            </a>
        </div>
        <div class="relative overflow-x-auto sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Abbrev
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Course Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4">
                                {{ ++$i }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $course->abbrev }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $course->course_title }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('courses.show', $course) }}">View</a>
                                <a href="{{ route('subjects', $course) }}">Subjects</a>
                                <a href="{{ route('sections', $course) }}">Sections</a>
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
</x-app-layout>
