<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function index()
    {
        if (!request()->user()->isAdmin()) {
            abort(403);
        }

        $audits = Audit::with('user')
                       ->latest()
                       ->paginate(20);

        return view('audits.index', compact('audits'));
    }
}