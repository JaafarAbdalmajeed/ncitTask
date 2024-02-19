<?php
namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            $users = User::where('type','student')->get();
            return response()->json($users);
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'passwordRepeat' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/|same:password',
        ], [
            'email.regex' => 'The email must be a valid Gmail address.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one digit, one special character, and no spaces.',
            'passwordRepeat.same' => 'The passwords do not match.',
        ]);



        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();
        return response()->json(['message' => 'Student added successfully'], 200);
        }

    public function edit($id)
    {
        $student = User::find($id);
        $form = view('admin.form_edit', ['student' => $student])->render();
        return response()->json(['form' => $form]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'email' => 'email|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i',
        ],[
            'email.email' => 'Please enter a valid email address.',
            'email.regex' => 'The email must be a valid Gmail address.',
        ]);
        // $existingUser = User::where('name', $request->name)->first();
        // if ($existingUser) {
        //     return response()->json(['errors' => ['name' => ['The name has already been taken.']]], 422);
        // }


        $student = User::find($id);
        if ($request->has('name')) {
            $student->name = $request->name;
        }
        if ($request->has('email')) {
            $student->email = $request->email;
        }
        $student->state = $request->state; // Update account state
        $student->save();


        return response()->json(['message' => 'Data received successfully']);
    }

    public function destroy($id)
{
    $student = User::find($id);
    if (!$student) {
        return response()->json(['message' => 'Student not found'], 404);
    }

    $student->delete();
    return response()->json(['message' => 'Student deleted successfully'], 200);
}


// public function fetch_students()
// {
//     $students = User::all();
//     return response()->json($students);
// }

// public function fetch_students2()
// {
//     $students = User::all();
//     return response()->json($students);
// }

public function fetch_students()
{
    $students = User::where('type', 'student')->get();
    return response()->json($students);
}

public function fetch_students2()
{
    $students = User::where('type', 'student')->get();
    return response()->json($students);
}



}
