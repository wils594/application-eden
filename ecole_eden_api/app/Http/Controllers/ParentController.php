<?php

namespace App\Http\Controllers;

use App\Models\User;

class ParentController extends Controller
{
    public function index()
    {
        $parents = User::orderBy('name')->get();

        return view('admin.parents.index', compact('parents'));
    }
}
