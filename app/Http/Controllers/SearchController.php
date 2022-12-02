<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    /**
     * Display the users and the groups whose names contains the text input.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    { 
        $name = $request->name;

        $results['users'] = User::query()
            ->where('name', 'LIKE', "%{$name}%")
            ->get();

        $results['groups'] = Group::query()
            ->where('name', 'LIKE', "%{$name}%")
            ->get();

        return view('search.search', ['substring' => $name, 'results' => $results]);
    }

}
