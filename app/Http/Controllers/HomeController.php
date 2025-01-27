<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MedicalVisit;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function doctorIndex()
    {
        return view('doctor.index');
    }

    public function patientIndex()
    {
        return view('patient.index');
    }

    // Update the userIndex method to return the users.dashboard view
    public function userIndex(Request $request)
    {
        return view('users.dashboard');
    }

    public function nurseIndex()
    {
        $nurseId = Auth::user()->id;
        $medicalVisits = MedicalVisit::where('nurse_id', $nurseId)->paginate(10);

        return view('medical_visit.index', compact('medicalVisits'));
    }
}
