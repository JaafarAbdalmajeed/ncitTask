<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    //
    public function fetchStudentGrades(Request $request)
    {
        $studentId = $request->studentId;
        $user = User::find($studentId);
        $grades = $user->grades()->with('subject')->get(); // Include subject information

        return response()->json($grades);
        // Debugging: Log the count of grades retrieved

    }


    public function fetchStudentMark(Request $request)
    {
        $studentId = $request->studentId;
        $subjectId = $request->subjectId;
        $grade = Grade::where('user_id', $studentId)->where('subject_id', $subjectId)->first();

        return response()->json($grade);
    }


    public function assignMark(Request $request)
    {
        $studentId = $request->input('student_id');
        $subjectId = $request->input('subject_id');
        $mark = $request->input('mark_obtained');

        // Update the mark for the specified student and subject
        $grade = Grade::where('user_id', $studentId)
            ->where('subject_id', $subjectId)
            ->first();

        if ($grade) {
            $grade->mark_obtained = $mark;
            $grade->save(); // Save the changes

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Grade record not found']);
    }
}


