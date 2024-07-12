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
    public function addSectionSchedule(SectionScheduleStoreRequest $request, Section $section): RedirectResponse
    {
        $section->schedules()->create($request->validated());
        return redirect()->route('sectionSchedules', $section)
                         ->with('status', 'schedule-stored');
    }
    public function addFacultySchedule(FacultyScheduleStoreRequest $request, Faculty $faculty): RedirectResponse
    {
        $faculty->schedules()->create($request->validated());
        return redirect()->route('facultySchedules', $faculty)
                         ->with('status', 'schedule-stored');
    }
}
