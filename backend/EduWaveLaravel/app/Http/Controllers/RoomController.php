<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Http\Resources\RoomCollection;
use App\Http\Resources\RoomResource;
use App\Models\Room;

class RoomController extends Controller
{

    public function index()
    {
        return new RoomCollection(Room::all());
    }

    public function store(RoomRequest $request)
    {
        $room = Room::create($request->validated());
        return new RoomResource($room);
    }

    public function show(Room $room)
    {
        return new RoomResource($room);
    }

    public function update(RoomRequest $request, Room $room)
    {
        $room->update($request->validated());
        return new RoomResource($room);
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return response()->noContent();
    }

}
