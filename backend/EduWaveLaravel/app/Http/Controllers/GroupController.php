<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\GroupResource;
use App\Models\Group;

class GroupController extends Controller
{

    public function index()
    {
        return new GroupCollection(Group::all());
    }

    public function store(GroupRequest $request)
    {
        $group = Group::create($request->validated());
        return new GroupResource($group);
    }

    public function show(Group $group)
    {
        return new GroupResource($group);
    }

    public function update(GroupRequest $request, Group $group)
    {
        $group->update($request->validated());
        return new GroupResource($group);
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return response()->noContent();
    }

}
