<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Helpers\ControllerHelper;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function __construct()
    {
        // TODO: is this actually useful? check routes/web.php
        $this->middleware('auth', ['only' => 'create', 'store']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('groups.create-group');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: Validate
        $group = new Group();
        $group->creator_id = Auth::id();

        if ($missing_field = ControllerHelper::checkRequiredFields($request, Group::REQUIRED_FIELDS)) {
            return Response("Missing field $missing_field", 401);
        }

        foreach (Group::REQUIRED_FIELDS as $field) {
            $group->$field = $request->$field;
        }

        $group->save();

        return redirect()->route('group.show', ['id' => $group->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function show($name)
    {
        // TODO: Validate
        if ($group = Group::where('name', $name)->first()) {
            return view('groups.group', ['group' => $group]);
        }
        
        return Response("Not found", 404);
    }

    // TODO
    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
