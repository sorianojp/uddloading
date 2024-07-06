<?php

namespace App\Http\Controllers;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\CourseStoreRequest;
use App\Http\Requests\CourseUpdateRequest;

class CourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::latest()->paginate(5);
        return view('courses.index', compact('courses'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function create(): View
    {
        return view('courses.create');
    }
    public function store(CourseStoreRequest $request): RedirectResponse
    {
        Course::create($request->validated());
        return redirect()->route('courses.create')
                         ->with('status', 'course-stored');
    }
    public function show(Course $course): View
    {
        return view('courses.show',compact('course'));
    }
    public function update(CourseUpdateRequest $request, Course $course): RedirectResponse
    {
        $course->update($request->validated());

        return redirect()->route('courses.show', $course)
                        ->with('status','course-updated');
    }
}
