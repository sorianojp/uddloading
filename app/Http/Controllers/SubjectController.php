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

    public function addSubject(SubjectStoreRequest $request, Course $course): RedirectResponse
    {
        $subject = new Subject($request->validated());
        $course->subjects()->save($subject);
        return redirect()->route('courses.show', $course)
                         ->with('status', 'subject-stored');
    }
}
