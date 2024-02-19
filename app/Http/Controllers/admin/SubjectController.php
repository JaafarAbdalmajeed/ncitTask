<?php

namespace App\Http\Controllers\admin;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Retrieve all subjects from the database
    $subjects = Subject::all();

    // Return the subjects as JSON response
    return response()->json($subjects);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|unique:subjects',
            'mark' => 'required|numeric|max:100', // Ensure mark is numeric
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'mark.required' => 'The mark field is required.',
            'mark.numeric' => 'The mark must be a number.',
            'mark.max' => 'The mark must not be greater than 100.',
        ]);

        // Create a new subject instance
        $subject = new Subject([
            'name' => $request->name,
            'mark' => $request->mark,
        ]);

        // Save the subject to the database
        $subject->save();

        // Return a success response
        return response()->json(['message' => 'Subject added successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function assignSubjectToStudent(Request $request)
    {
        // Validate the request data
        $request->validate([
            'user_id' => 'required',
            'subject_id' => 'required',
        ]);


        // Check if the grade already exists for the student and subject
        $existingGrade = Grade::where('user_id', $request->user_id)
                            ->where('subject_id', $request->subject_id)
                            ->first();

        if ($existingGrade) {
            return response()->json(['message' => 'Subject already assigned to student'], 400);
        }

        // Create a new grade record for the student and subject
        $grade = new Grade([
            'user_id' => $request->user_id,
            'subject_id' => $request->subject_id,
        ]);

        $grade->save();

        return response()->json(['message' => 'Subject assigned to student successfully'], 200);
    }


    public function fetch_subjects()
{
    // Retrieve all subjects from the database
    $subjects = Subject::all();

    // Return the subjects as JSON response
    return response()->json($subjects);
}

public function fetchSubjectsForStudent($studentId)
    {
        // Fetch subjects assigned to the specified student
        $grades = Grade::where('user_id', $studentId)->with('subject')->get();

        // Extract subjects from the grades
        $subjects = $grades->pluck('subject');

        return response()->json($subjects);
    }


    public function setGrade(Request $request)
    {
        // Validate the request data
        $request->validate([
            'student_id' => 'required',
            'subject_id' => 'required',

            'grade' => 'required|numeric',
        ]);

        // Find the grade record for the specified student and subject
        $grade = Grade::where('user_id', $request->student_id)
                    ->where('subject_id', $request->subject_id)
                    ->first();

        // If the grade record doesn't exist, create a new one
        if (!$grade) {
            $grade = new Grade([
                'user_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'mark_obtained' => $request->grade,
            ]);

            $grade->save();

            return response()->json(['message' => 'Grade set successfully'], 200);
        }

        // Update the existing grade record
        $grade->mark_obtained = $request->grade;
        $grade->save();

        return response()->json(['message' => 'Grade updated successfully'], 200);
    }

}
