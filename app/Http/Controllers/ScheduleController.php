<?php

namespace App\Http\Controllers;
use App\Models\Section;
use App\Models\Schedule;
use App\Models\Room;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ScheduleStoreRequest;

class ScheduleController extends Controller
{
    public function index(): View
    {
        $sections = Section::latest()->paginate(5);
        return view('schedules.sections', compact('sections'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function schedules(Section $section): View
    {
        $rooms = Room::all();
        return view('schedules.index',compact('section', 'rooms'));
    }
    public function addSchedule(ScheduleStoreRequest $request, Section $section): RedirectResponse
    {
        $section->schedules()->create($request->validated());
        return redirect()->route('schedules', $section)
                         ->with('status', 'schedule-stored');
    }
}
