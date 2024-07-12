<!-- resources/views/schedules/faculty.blade.php -->

<x-app-layout>
    <x-slot name="header">
        {{ $faculty->full_name }}
    </x-slot>
    <div class="max-w-full mx-auto space-y-2">
        <div class="grid grid-cols-7 gap-2">
            <x-card class="col-span-2">
                <h1>Add Schedule</h1>
                <form method="POST" action="{{ route('addFacultySchedule', $faculty) }}" class="space-y-2">
                    @csrf
                    <!-- Subject -->
                    <div>
                        <x-input-label for="subject_id" :value="__('Subject')" />
                        <x-select-input name="subject_id" id="subject_id">
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('subject_id')" />
                    </div>
                    <div>
                        <x-input-label for="room_id" :value="__('Room')" />
                        <x-select-input name="room_id" id="room_id">
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('room_id')" />
                    </div>
                    <div>
                        <x-input-label for="section_id" :value="__('Section')" />
                        <x-select-input name="section_id" id="section_id">
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('section_id')" />
                    </div>
                    <div class="grid grid-cols-2 gap-2">
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
                    </div>
                    @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                        <div>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="{{ $day }}" id="{{ $day }}"
                                    value="1" class="sr-only peer"
                                    @if (old($day, $schedule->$day ?? 0)) checked @endif>
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                </div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300 uppercase">{{ $day }}</span>
                            </label>
                        </div>
                    @endforeach
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
            <x-card class="col-span-5">
                <h1>{{ $faculty->full_name }}'s Schedule</h1>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full table-fixed text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-2">TIME</th>
                                <th scope="col" class="p-2">MONDAY</th>
                                <th scope="col" class="p-2">TUESDAY</th>
                                <th scope="col" class="p-2">WEDNESDAY</th>
                                <th scope="col" class="p-2">THURSDAY</th>
                                <th scope="col" class="p-2">FRIDAY</th>
                                <th scope="col" class="p-2">SATURDAY</th>
                                <th scope="col" class="p-2">SUNDAY</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $startTime = strtotime('07:00:00');
                                $endTime = strtotime('19:30:00');
                                $interval = 30 * 60; // 30 minutes
                                $timeSlots = [];
                                foreach ($faculty->schedules as $schedule) {
                                    foreach (
                                        ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']
                                        as $day
                                    ) {
                                        if ($schedule->$day) {
                                            $timeSlots[$day][] = [
                                                'start' => strtotime($schedule->time_start),
                                                'end' => strtotime($schedule->time_end),
                                                'info' =>
                                                    '<span class="font-bold">' .
                                                    $schedule->section->section_name .
                                                    '</span></br>' .
                                                    $schedule->room->room_name .
                                                    '</br>' .
                                                    '<span class="font-bold">' .
                                                    date('h:i A', strtotime($schedule->time_start)) .
                                                    ' - ' .
                                                    date('h:i A', strtotime($schedule->time_end)) .
                                                    '</span></br>' .
                                                    $schedule->subject->subject_name,
                                            ];
                                        }
                                    }
                                }
                            @endphp
                            @for ($time = $startTime; $time <= $endTime; $time += $interval)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="p-2">{{ date('h:i:s A', $time) }}</td>
                                    @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                        @php
                                            $merged = false;
                                            if (!empty($timeSlots[$day])) {
                                                foreach ($timeSlots[$day] as $index => $slot) {
                                                    if ($time == $slot['start']) {
                                                        $rowspan = ($slot['end'] - $slot['start']) / $interval;
                                                        echo '<td class="text-white p-2 bg-blue-900" rowspan="' .
                                                            $rowspan .
                                                            '">' .
                                                            $slot['info'] .
                                                            '</td>';
                                                        $merged = true;
                                                        break;
                                                    } elseif ($time > $slot['start'] && $time < $slot['end']) {
                                                        $merged = true;
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp
                                        @unless ($merged)
                                            <td class="p-2"></td>
                                        @endunless
                                    @endforeach
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
