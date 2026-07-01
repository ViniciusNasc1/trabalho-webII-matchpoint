<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $invites = $user->teams()->wherePivot('status', 'invited')->get();
        return view('dashboard', compact('invites'));
    }
}