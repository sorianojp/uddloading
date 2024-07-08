<x-app-layout>
    <x-slot name="header">
        {{ __('Rooms') }}
    </x-slot>
    <div class="max-w-7xl mx-auto space-y-2">
        <div class="grid grid-cols-2 gap-2">
            <x-card>
                <h1>Add Room</h1>
                <form method="POST" action="{{ route('rooms.store') }}">
                    @csrf
                    <!-- Room Name -->
                    <div>
                        <x-input-label for="room_name" :value="__('Room Name')" />
                        <x-text-input id="room_name" type="text" name="room_name" :value="old('room_name')" autofocus
                            autocomplete="room_name" />
                        <x-input-error :messages="$errors->get('room_name')" />
                    </div>
                    <div class="flex items-center justify-end mt-2 gap-2">
                        @if (session('status') === 'room-stored')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                                {{ __('Saved') }}
                            </p>
                        @endif
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </x-card>
            <x-card>
                <h1>Rooms</h1>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Room Name
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rooms as $room)
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        {{ $room->room_name }}
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
