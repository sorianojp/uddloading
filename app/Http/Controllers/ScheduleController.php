<?php

namespace App\Http\Controllers;
use App\Models\Section;
use App\Models\Schedule;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Faculty;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SectionScheduleStoreRequest;
use App\Http\Requests\FacultyScheduleStoreRequest;
use App\Http\Requests\RoomScheduleStoreRequest;
class ScheduleController extends Controller
{
    public function index(): View
    {
        $sections = Section::latest()->paginate(5);
        $faculties = Faculty::latest()->paginate(5);
        $rooms = Room::latest()->paginate(5);
        return view('schedules.schedule', compact('sections', 'faculties', 'rooms'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function sectionSchedules(Section $section): View
    {
        $subjects = Subject::all();
        $rooms = Room::all();
        $faculties = Faculty::all();
        return view('schedules.section',compact('section', 'subjects', 'rooms', 'faculties'));
    }
    public function facultySchedules(Faculty $faculty): View
    {
        $subjects = Subject::all();
        $rooms = Room::all();
        $sections = Section::all();
        return view('schedules.faculty',compact('faculty', 'subjects', 'rooms', 'sections'));
    }
    public function roomSchedules(Room $room): View
    {
        $subjects = Subject::all();
        $faculties = Faculty::all();
        $sections = Section::all();
        return view('schedules.room',compact('faculties', 'subjects', 'room', 'sections'));
    }
    public function addSectionSchedule(SectionScheduleStoreRequest $request, Section $section): RedirectResponse
    {
        $conflicts = $this->getConflicts($request);

        if ($conflicts->isNotEmpty()) {
            return redirect()->back()->withErrors(['conflicts' => $this->formatConflicts($conflicts)]);
        }

        $section->schedules()->create($request->validated());
        return redirect()->route('sectionSchedules', $section)
                         ->with('status', 'schedule-stored');
    }

    public function addFacultySchedule(FacultyScheduleStoreRequest $request, Faculty $faculty): RedirectResponse
    {
        $conflicts = $this->getConflicts($request);

        if ($conflicts->isNotEmpty()) {
            return redirect()->back()->withErrors(['conflicts' => $this->formatConflicts($conflicts)]);
        }

        $faculty->schedules()->create($request->validated());
        return redirect()->route('facultySchedules', $faculty)
                         ->with('status', 'schedule-stored');
    }

    public function addRoomSchedule(RoomScheduleStoreRequest $request, Room $room): RedirectResponse
    {
        $conflicts = $this->getConflicts($request);

        if ($conflicts->isNotEmpty()) {
            return redirect()->back()->withErrors(['conflicts' => $this->formatConflicts($conflicts)]);
        }

        $room->schedules()->create($request->validated());
        return redirect()->route('roomSchedules', $room)
                         ->with('status', 'schedule-stored');
    }

    private function getConflicts($request)
    {
        $query = Schedule::query();

        // Check each day
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($days as $day) {
            if ($request->input($day)) {
                $query->orWhere(function ($query) use ($request, $day) {
                    $query->where($day, true)
                        ->where(function ($query) use ($request) {
                            $query->where('room_id', $request->room_id)
                                ->orWhere('section_id', $request->section_id)
                                ->orWhere('faculty_id', $request->faculty_id);
                        })
                        ->where(function ($query) use ($request) {
                            $query->whereTime('time_start', '<', $request->time_end)
                                ->whereTime('time_end', '>', $request->time_start);
                        });
                });
            }
        }

        return $query->get();
    }

    private function formatConflicts($conflicts)
    {
        return $conflicts->map(function ($conflict) {
            $days = [];

            if ($conflict->monday) $days[] = 'Monday';
            if ($conflict->tuesday) $days[] = 'Tuesday';
            if ($conflict->wednesday) $days[] = 'Wednesday';
            if ($conflict->thursday) $days[] = 'Thursday';
            if ($conflict->friday) $days[] = 'Friday';
            if ($conflict->saturday) $days[] = 'Saturday';
            if ($conflict->sunday) $days[] = 'Sunday';

            return 'Days: ' . implode(', ', $days) .
                   ', Subject: ' . $conflict->subject->subject_name .
                   ', Room: ' . $conflict->room->room_name .
                   ', Faculty: ' . ($conflict->faculty ? $conflict->faculty->full_name : 'N/A') .
                   ', Time: ' . $conflict->time_start . ' - ' . $conflict->time_end;
        })->toArray();
    }
}
