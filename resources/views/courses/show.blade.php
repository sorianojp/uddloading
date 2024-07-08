<x-app-layout>
    <x-slot name="header">
        {{ $course->course_title }}
    </x-slot>
    <div class="max-w-2xl mx-auto space-y-2">
        <x-card>
            <!-- Edit Form -->
            <div>
                <form action="{{ route('courses.update', $course) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Course Title -->
                    <div>
                        <x-input-label for="course_title" :value="__('Course Title')" />
                        <x-text-input id="course_title" type="text" name="course_title" :value="old('course_title', $course->course_title)" autofocus
                            autocomplete="course_title" />
                        <x-input-error :messages="$errors->get('course_title')" />
                    </div>
                    <!-- Abbrev -->
                    <div>
                        <x-input-label for="abbrev" :value="__('Abbreviation')" />
                        <x-text-input id="abbrev" type="text" name="abbrev" :value="old('abbrev', $course->abbrev)" autofocus
                            autocomplete="abbrev" />
                        <x-input-error :messages="$errors->get('abbrev')" />
                    </div>
                    <div class="flex items-center justify-end mt-2 gap-2">
                        @if (session('status') === 'course-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                                {{ __('Saved') }}
                            </p>
                        @endif
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </x-card>
    </div>
</x-app-layout>
