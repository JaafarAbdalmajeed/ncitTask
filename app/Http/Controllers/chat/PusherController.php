<?php

namespace App\Http\Controllers\chat;

use Pusher\Pusher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PusherController extends Controller
{
    //
    public function sendMessage(Request $request) {
        $return_data['response_code'] = 0;
        $return_data['message'] = 'Something went wrong, Please try again later.';

        $rules = ['message' => 'required'];
        $messages = ['message.required' => 'Please enter message to communicate.'];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = implode("", $validator->messages()->all());
            $return_data['message'] = $message;
            return $return_data;
        }

        try {
            $options = [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true
            ];

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );

            $response = $pusher->trigger('my-chat-channel', 'my-new-message-event', ['message' => $request->message]);
            if($response){
                $return_data['response_code'] = 1;
                $return_data['message'] = 'Success.';
            }
        } catch (\Exception $e) {
            $return_data['message'] = $e->getMessage();
        }
        return $return_data;
    }
}
