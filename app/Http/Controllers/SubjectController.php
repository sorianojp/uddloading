<?php

namespace App\Http\Controllers;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\SubjectStoreRequest;
use App\Http\Requests\SubjectUpdateRequest;

class SubjectController extends Controller
{
    public function subjects(Course $course): View
    {
        return view('subjects.index',compact('course'));
    }
    public function addSubject(SubjectStoreRequest $request, Course $course): RedirectResponse
    {
        $course->subjects()->create($request->validated());
        return redirect()->route('subjects', $course)
                         ->with('status', 'subject-stored');
    }
}
