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
class ScheduleController extends Controller
{
    public function index(): View
    {
        $sections = Section::latest()->paginate(5);
        $faculties = Faculty::latest()->paginate(5);
        return view('schedules.schedule', compact('sections', 'faculties'))
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
    private function hasConflict($request)
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        $query = Schedule::where('room_id', $request->room_id)
                         ->where(function($query) use ($request) {
                             $query->whereBetween('time_start', [$request->time_start, $request->time_end])
                                   ->orWhereBetween('time_end', [$request->time_start, $request->time_end])
                                   ->orWhere(function($query) use ($request) {
                                       $query->where('time_start', '<', $request->time_start)
                                             ->where('time_end', '>', $request->time_end);
                                   });
                         });

        $query->where(function ($q) use ($request, $days) {
            foreach ($days as $day) {
                if ($request->$day) {
                    $q->orWhere($day, true);
                }
            }
        });

        return $query->with(['subject', 'room', 'faculty', 'section'])->get();
    }

    public function addSectionSchedule(SectionScheduleStoreRequest $request, Section $section): RedirectResponse
    {
        $conflicts = $this->hasConflict($request);
        if ($conflicts->isNotEmpty()) {
            return redirect()->back()->withErrors(['conflict' => 'Schedule conflict detected.', 'conflict_details' => json_encode($conflicts)]);
        }

        $section->schedules()->create($request->validated());
        return redirect()->route('sectionSchedules', $section)->with('status', 'schedule-stored');
    }

    public function addFacultySchedule(FacultyScheduleStoreRequest $request, Faculty $faculty): RedirectResponse
    {
        $conflicts = $this->hasConflict($request);
        if ($conflicts->isNotEmpty()) {
            return redirect()->back()->withErrors(['conflict' => 'Schedule conflict detected.', 'conflict_details' => json_encode($conflicts)]);
        }

        $faculty->schedules()->create($request->validated());
        return redirect()->route('facultySchedules', $faculty)->with('status', 'schedule-stored');
    }


}
