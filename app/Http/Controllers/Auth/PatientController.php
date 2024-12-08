<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::where('psychologist_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('patients.index', compact('patients'));
    }
}
