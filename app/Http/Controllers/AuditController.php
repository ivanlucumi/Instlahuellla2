<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index()
    {
        $audits = \App\Models\Audit::with('user')->latest()->paginate(20);
        return view('Audit.Index', compact('audits'));
    }
}
