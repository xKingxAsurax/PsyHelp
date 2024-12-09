<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class SomeController extends Controller
{
    public function someMethod()
    {
        $activePatients = Patient::whereHas('appointments', function($query) {
            $query->where('status', 'programada');
        })->with('user')->get();

        return view('patients.index', compact('activePatients'));
    }
} 