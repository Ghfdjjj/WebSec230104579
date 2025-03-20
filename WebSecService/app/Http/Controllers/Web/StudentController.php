<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of all student profiles.
     */
    public function index()
    {
        $students = Student::where('user_id', auth()->id())->get();
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student profile.
     */
    public function create()
    {
        return view('students.create'); // Ensure students.create extends layouts.master
    }

    /**
     * Store a newly created student profile in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'major' => 'required|string|max:255',
        ]);

        // Create the student
        Student::create([
            'name' => $request->name,
            'age' => $request->age,
            'major' => $request->major,
            'user_id' => auth()->id(),
        ]);

        // Redirect to students index with success message
        return redirect()->route('students.index')->with('success', 'Student created successfully!');
    }

    /**
     * Show the form for editing the specified student profile.
     */
    public function edit(Student $student)
    {
        if ($student->user_id !== auth()->id()) {
            abort(403);
        }

        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student profile in storage.
     */
    public function update(Request $request, Student $student)
    {
        if ($student->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'major' => 'required|string|max:255',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Student profile updated successfully.');
    }

    /**
     * Remove the specified student profile from storage.
     */
    public function destroy(Student $student)
    {
        if ($student->user_id !== auth()->id()) {
            abort(403);
        }

        $student->delete();
        return redirect()->route('students.index')
                         ->with('success', 'Student deleted successfully');
    }
}
