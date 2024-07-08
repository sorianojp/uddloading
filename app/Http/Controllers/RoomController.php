<?php

namespace App\Http\Controllers;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\RoomStoreRequest;
use App\Http\Requests\RoomUpdateRequest;

class RoomController extends Controller
{
    public function index(): View
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }
    public function store(RoomStoreRequest $request): RedirectResponse
    {
        Room::create($request->validated());
        return redirect()->route('rooms.index')
                         ->with('status', 'room-stored');
    }
}
