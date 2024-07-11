<x-app-layout>
    <x-slot name="header">
        {{ $section->section_name }}
    </x-slot>
    <div class="max-w-full mx-auto space-y-2">
        <div class="grid grid-cols-7 gap-2">
            <x-card class="col-span-2">
                <h1>Add Schedule</h1>
                <form method="POST" action="{{ route('addSchedule', $section) }}" class="space-y-2">
                    @csrf
                    <!-- Subject -->
                    <div>
                        <x-input-label for="subject_id" :value="__('Subject')" />
                        <x-select-input name="subject_id" id="subject_id">
                            @foreach ($section->course->subjects as $subject)
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
                        <x-input-label for="faculty_id" :value="__('Faculty')" />
                        <x-select-input name="faculty_id" id="faculty_id">
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->id }}">{{ $faculty->full_name }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('faculty_id')" />
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
                <h1>Schedules</h1>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full table-fixed text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-2 w-1/8">TIME</th>
                                <th scope="col" class="p-2 w-1/8">MONDAY</th>
                                <th scope="col" class="p-2 w-1/8">TUESDAY</th>
                                <th scope="col" class="p-2 w-1/8">WEDNESDAY</th>
                                <th scope="col" class="p-2 w-1/8">THURSDAY</th>
                                <th scope="col" class="p-2 w-1/8">FRIDAY</th>
                                <th scope="col" class="p-2 w-1/8">SATURDAY</th>
                                <th scope="col" class="p-2 w-1/8">SUNDAY</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $startTime = strtotime('07:00:00');
                                $endTime = strtotime('19:30:00');
                                $interval = 30 * 60; // 30 minutes

                                $scheduleData = [];
                                foreach ($section->schedules as $schedule) {
                                    foreach (
                                        ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']
                                        as $day
                                    ) {
                                        if ($schedule->$day) {
                                            $time_start = strtotime($schedule->time_start);
                                            $time_end = strtotime($schedule->time_end);
                                            for ($time = $time_start; $time < $time_end; $time += $interval) {
                                                $scheduleData[$time][$day] = [
                                                    'subject_name' => $schedule->subject->subject_name,
                                                    'room_name' => $schedule->room->room_name,
                                                    'faculty_full_name' => $schedule->faculty->full_name,
                                                    'time_start' => $schedule->time_start,
                                                    'time_end' => $schedule->time_end,
                                                ];
                                            }
                                        }
                                    }
                                }
                            @endphp
                            @for ($time = $startTime; $time <= $endTime; $time += $interval)
                                <tr class="border-b dark:border-gray-700">
                                    <th class="p-2 whitespace-nowrap">{{ date('h:i A', $time) }}</th>
                                    @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                        @php
                                            $schedule = $scheduleData[$time][$day] ?? null;
                                            $isMergedCell =
                                                isset($schedule) &&
                                                (!isset($scheduleData[$time - $interval][$day]) ||
                                                    $scheduleData[$time - $interval][$day] !== $schedule);
                                            $rowspan = 0;
                                            if ($isMergedCell) {
                                                $rowStart = $time;
                                                while (
                                                    isset($scheduleData[$rowStart][$day]) &&
                                                    $scheduleData[$rowStart][$day] === $schedule
                                                ) {
                                                    $rowspan++;
                                                    $rowStart += $interval;
                                                }
                                            }
                                        @endphp
                                        @if ($isMergedCell)
                                            <td class="p-2 bg-blue-800 text-white" rowspan="{{ $rowspan }}">
                                                <div><span class="font-bold">{{ $schedule['subject_name'] }}</span>
                                                </div>
                                                <div> {{ date('h:i A', strtotime($schedule['time_start'])) }} -
                                                    {{ date('h:i A', strtotime($schedule['time_end'])) }}</div>
                                                <div>{{ $schedule['room_name'] }}</div>
                                                <div> {{ $schedule['faculty_full_name'] }}</div>
                                            </td>
                                        @elseif (!isset($scheduleData[$time - $interval][$day]))
                                            <td class="p-2"></td>
                                        @endif
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
