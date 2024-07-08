<x-app-layout>
    <x-slot name="header">
        {{ $section->section_name }}
    </x-slot>
    <div class="max-w-full mx-auto space-y-2">
        <div class="grid grid-cols-3 gap-2">
            <x-card>
                <h1>Add Schedule</h1>
                <form method="POST" action="{{ route('addSchedule', $section) }}">
                    @csrf
                    <!-- Subject -->
                    <div>
                        <x-input-label for="subject_id" :value="__('Subject')" />
                        <select name="subject_id" id="subject_id">
                            @foreach ($section->course->subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('subject_id')" />
                    </div>
                    <div>
                        <x-input-label for="room_id" :value="__('Room')" />
                        <select name="room_id" id="room_id">
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('room_id')" />
                    </div>
                    <div>
                        <x-input-label for="days" :value="__('Days')" />
                        <select name="days[]" id="days" multiple>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                        <x-input-error :messages="$errors->get('days')" />
                    </div>
                    <div>
                        <x-input-label for="time_start" :value="__('Start Time')" />
                        <x-text-input id="time_start" type="time" name="time_start" :value="old('time_start')" autofocus
                            autocomplete="time_start" />
                        <x-input-error :messages="$errors->get('time_start')" />
                    </div>

                    <div>
                        <x-input-label for="time_end" :value="__('End Time')" />
                        <x-text-input id="time_end" type="time" name="time_end" :value="old('time_end')" autofocus
                            autocomplete="time_end" />
                        <x-input-error :messages="$errors->get('time_end')" />
                    </div>
                    <div class="flex items-center justify-end mt-2 gap-2">
                        @if (session('status') === 'schedule-stored')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                                {{ __('Saved') }}
                            </p>
                        @endif
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </x-card>
            <x-card class="col-span-2">
                <h1>Schedules</h1>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Code</th>
                                <th scope="col" class="px-6 py-3">Subject Name</th>
                                <th scope="col" class="px-6 py-3">LEC/LAB</th>
                                <th scope="col" class="px-6 py-3">Section</th>
                                <th scope="col" class="px-6 py-3">
                                    schedule
                                </th>
                                <th scope="col" class="px-6 py-3">Room</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($section->schedules as $schedule)
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-6 py-4">{{ $schedule->subject->subject_code }}</td>
                                    <td class="px-6 py-4">{{ $schedule->subject->subject_name }}</td>
                                    <td class="px-6 py-4">{{ $schedule->subject->lec }}/{{ $schedule->subject->lab }}
                                    </td>
                                    <td class="px-6 py-4">{{ $section->section_name }}</td>
                                    <td class="px-6 py-4">
                                        {{ implode(' ', explode(',', $schedule->days)) }}
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->time_start)->format('g:iA') }}-
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->time_end)->format('g:iA') }}
                                    </td>
                                    <td class="px-6 py-4">{{ $schedule->room->room_name }}</td>
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
