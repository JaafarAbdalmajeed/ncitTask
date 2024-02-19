<?php

namespace App\Http\Controllers\chat;

use App\Models\User;
use App\Models\Grade;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    public function index()
    {
        // Get the logged-in user
        $user = Auth::user();

        // Fetch users based on user type
        if ($user->type == 'admin') {
            // Fetch all students
            $users = User::where('type', 'student')->get();
        } else {
            // Fetch students in the same subjects as the current user
            $admin = User::find(1);
            $subjects = Grade::where('user_id', $user->id)->with('subject')->get();
            $subjectIds = $subjects->pluck('subject_id')->toArray();

            $users = User::where('type', 'student')->where('id','<>',$user->id)
                            ->whereHas('grades', function ($query) use ($subjectIds) {
                                $query->whereIn('subject_id', $subjectIds);
                            })
                            ->get();
                            $users->push($admin);

        }


        // Pass users to the view
        return view('chat.chatCopy', ['users' => $users]);
    }


        public function sendMessage($user_id, Request $request, User $userObj)
        {
            $userObj->sendMessage($user_id, $request->message, $request->sender);
            return response()->json('Message send');
        }

    // public function sendMessage($user_id, Request $request)
    // {
    //     $user = auth()->user();
    //     $message = $request->input('message');

    //     // Call the sendMessage method on the User model to handle the message sending
    //     $user->sendMessage($user_id, $message);

    //     return response()->json(['status' => 'Message sent']);
    // }





















































    //

    // public function chat($user_id)
    // {
    //     $receiver = User::where('id', $user_id)->first();
    //     return view('chat.chat', compact('receiver'));
    // }

//     public function chat()
//     {
//         return view('chat.chatCopy');
//     }

//     public function chatStudents($id)
//     {
//         $userId = Auth::id();
//         $adminId = 1; // Assuming the admin user has an ID of 1
//         $admin = User::find($adminId);

//         $students = Grade::where('subject_id', $id)
//             ->where('user_id', '<>', $userId)
//             ->with('user')
//             ->get();

//         // Convert the collection to an array
//         $students = $students->toArray();

//         // Append the admin user to the list of students
//         $students[] = [
//             'user' => $admin,
//         ];

//         return response()->json($students);
//     }




    // public function sendMessage($user_id, Request $request, User $userObj)
    // {
    //     $userObj->sendMessage($user_id, $request->message);
    //     return response()->json('Message send');
    // }


//     // public function getChatData($user_id)sendMessage
//     // {

//     //     // $chatData = Message::where('sender',Auth::id())->where('receiver', 1)->get();
//     //     $chatData = Message::all();

//     //     return response()->json($chatData);
//     // }

//     public function getChatData($user_id)
// {
//     $authUserId = Auth::id();
//     $sentMessages = Message::where('sender', $authUserId)
//                             ->where('receiver', $user_id)
//                             ->orderBy('created_at', 'asc')
//                             ->get();

//     $receivedMessages = Message::where('sender', $user_id)
//                                 ->where('receiver', $authUserId)
//                                 ->orderBy('created_at', 'asc')
//                                 ->get();

//     $combinedMessages = $sentMessages->concat($receivedMessages);

//     $sortedMessages = $combinedMessages->sortBy('created_at');

//     $receiverName = User::find($user_id)->name; // Assuming you have a User model
//     $data = [
//         'messages' => $sortedMessages,
//         'receiverName' => $receiverName,
//     ];


//     return response()->json($sortedMessages);
// }
    }
