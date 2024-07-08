<?php

namespace App\Http\Controllers;
use App\Models\Section;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\SectionStoreRequest;
use App\Http\Requests\SectionUpdateRequest;

class SectionController extends Controller
{
    public function sections(Course $course): View
    {
        return view('sections.index',compact('course'));
    }
    public function addSection(SectionStoreRequest $request, Course $course): RedirectResponse
    {
        $section = new Section($request->validated());
        $course->sections()->save($section);
        return redirect()->route('sections', $course)
                         ->with('status', 'section-stored');
    }
}
