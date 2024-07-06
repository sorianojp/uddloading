<?php

namespace App\Http\Controllers;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\SubjectStoreRequest;
use App\Http\Requests\SubjectUpdateRequest;

class SubjectController extends Controller
{
    public function index(): View
    {
        $subjects = Subject::latest()->paginate(5);
        return view('subjects.index', compact('subjects'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function create(): View
    {
        return view('subjects.create');
    }
    public function store(SubjectStoreRequest $request): RedirectResponse
    {
        Subject::create($request->validated());
        return redirect()->route('subjects.create')
                         ->with('status', 'subject-stored');
    }
    public function show(Subject $subject): View
    {
        return view('subjects.show',compact('subject'));
    }
    public function edit(Subject $subject): View
    {
        return view('subjects.edit',compact('subjects'));
    }
    public function update(SubjectUpdateRequest $request, Subject $subject): RedirectResponse
    {
        $subject->update($request->validated());

        return redirect()->route('subjects.index')
                        ->with('status','subject-updated');
    }
    public function destroy(Subject $subject): RedirectResponse
    {
        $subject->delete();

        return redirect()->route('subjects.index')
                        ->with('status','subject-deleted');
    }
}
