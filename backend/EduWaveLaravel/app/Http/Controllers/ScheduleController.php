<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Http\Resources\ScheduleCollection;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;

class ScheduleController extends Controller
{

    public function index()
    {
        return new ScheduleCollection(Schedule::all());
    }

    public function store(ScheduleRequest $request)
    {
        $schedule = Schedule::create($request->validated());
        return new ScheduleResource($schedule);
    }

    public function show(Schedule $schedule)
    {
        return new ScheduleResource($schedule);
    }

    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $schedule->update($request->validated());
        return new ScheduleResource($schedule);
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return response()->noContent();
    }

}
