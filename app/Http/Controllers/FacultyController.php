<?php

namespace App\Http\Controllers;
use App\Models\Faculty;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\FacultyStoreRequest;

class FacultyController extends Controller
{
    public function index(): View
    {
        $faculties = Faculty::all();
        return view('faculties.index', compact('faculties'));
    }
    public function store(FacultyStoreRequest $request): RedirectResponse
    {
        Faculty::create($request->validated());
        return redirect()->route('faculties.index')
                         ->with('status', 'faculty-stored');
    }
}
