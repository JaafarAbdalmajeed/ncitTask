<?php

namespace App\Http\Controllers\student;

use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    //
    public function index()
    {
        $id = Auth::id();
        $user = User::find($id);

        if ($user->state) {
            $grades = $user->grades;
            return view('student.index', compact('user', 'grades'));
        } else {
            return redirect()->route('login')->with('warning', 'Your account is inactive. Please contact the administrator.');
        }
    }


    public function students($id)
    {
        $students = Grade::where('subject_id', $id)->with('user')->get();
        return response()->json($students);

    }
}
