<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MedicalVisit;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Display a list of users
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('middle_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('unique_id', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate(5); // Retrieve 5 users per page
        return view('user.index', compact('users'));
    }

    // Show the admin dashboard
    public function adminDashboard()
    {
        $totalPatients = User::where('usertype', 'patient')->count();
        $activeDoctors = User::where('usertype', 'doctor')->count();
        $activeNurses = User::where('usertype', 'nurse')->count();
        // Replace with actual logic to fetch pending appointments
        $totalMedicalVisits = MedicalVisit::count(); // Fetch the count of medical visits

        return view('admin.index', compact('totalPatients', 'activeDoctors', 'activeNurses', 'totalMedicalVisits'));
    }

    // Show the form for creating a new user
    public function create()
    {
        return view('user.create');
    }

    // Store a newly created user
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'usertype' => 'required|in:doctor,admin,patient,nurse,user',
        ]);

        $currentYear = date('Y');
        $prefix = strtoupper(substr($request->usertype, 0, 3));
        $lastUser = User::where('usertype', $request->usertype)->whereYear('created_at', $currentYear)->orderBy('id', 'desc')->first();
        $sequenceNumber = $lastUser ? intval(substr($lastUser->unique_id, -4)) + 1 : 1;
        $uniqueId = sprintf('%s-%s-%04d', $prefix, $currentYear, $sequenceNumber);

        $user = new User;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->date_of_birth = $request->date_of_birth;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->usertype = $request->usertype;
        $user->unique_id = $uniqueId; // Generate a unique ID for the user
        $user->save();

        return redirect()->route('admin.user.index')->with('status', 'User created successfully!');
        return $user; 
    }

    // Show the form for editing a user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    // Update the specified user
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . $id,
            'usertype' => 'required|in:doctor,admin,patient,nurse',
        ]);

        $user = User::findOrFail($id);
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->date_of_birth = $request->date_of_birth;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($user->usertype !== $request->usertype) {
            $currentYear = date('Y');
            $prefix = strtoupper(substr($request->usertype, 0, 3));
            $lastUser = User::where('usertype', $request->usertype)->whereYear('created_at', $currentYear)->orderBy('id', 'desc')->first();
            $sequenceNumber = $lastUser ? intval(substr($lastUser->unique_id, -4)) + 1 : 1;
            $uniqueId = sprintf('%s-%s-%04d', $prefix, $currentYear, $sequenceNumber);
            $user->unique_id = $uniqueId;
        }

        $user->usertype = $request->usertype;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    // Remove the specified user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}
