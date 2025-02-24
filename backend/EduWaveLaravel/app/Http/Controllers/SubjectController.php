<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Http\Resources\SubjectCollection;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;

class SubjectController extends Controller
{

    public function index()
    {
        return new SubjectCollection(Subject::all());
    }

    public function store(SubjectRequest $request)
    {
        $subject = Subject::create($request->validated());
        return new SubjectResource($subject);
    }

    public function show(Subject $subject)
    {
        return new SubjectResource($subject);
    }

    public function update(SubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());
        return new SubjectResource($subject);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->noContent();
    }

}
