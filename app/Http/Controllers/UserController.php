<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageEvent;

class UserController extends Controller
{
    public function index(){
        $users=User::whereNotIn('id',[auth()->user()->id])->get();
        return view('home',compact('users'));
    }

    public function saveChat(Request $request){
        try {
            $chat=Chat::create([
                'sender_id'=>$request->sender_id,
                'receiver_id'=>$request->receiver_id,
                'message'=>$request->message
            ]);

            event(new MessageEvent($chat));

            return response()->json(['success'=>true,'data'=>$chat]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>false,'msg'=>$th->getMessage()]);
        }
    }

    public function loadChat(Request $request){
        try {
            $chats=Chat::where(function($q) use($request){
                $q->where('sender_id','=',$request->sender_id)
                ->orWhere('sender_id','=',$request->receiver_id);
            })->where(function($q) use($request){
                $q->where('receiver_id','=',$request->sender_id)
                ->orWhere('receiver_id','=',$request->receiver_id);
            })->get();

            $user=User::find($request->receiver_id);
            return response()->json(['success'=>true,'data'=>$chats ,'user'=>$user]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>false,'msg'=>$th->getMessage()]);

        }
    }
}
