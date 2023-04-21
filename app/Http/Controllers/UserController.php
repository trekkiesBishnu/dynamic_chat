<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Chat;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Events\MessageEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        if(Auth::id()){

            $users=User::whereNotIn('id',[auth()->user()->id])->get();
            return view('home',compact('users'));
        }else{
            return "login";
        }
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

    public function userProfile(){
        $id=Auth::id();
        if($id){
            $user=User::find($id);
            return view('user.userProfile',compact('user'));
        }
        
    }

    public function ProfileChange(Request $request,$id){
        // dd($request->img);
       
        $user=User::find($id);
        if($user){
            
            if($user->hasMedia('user_image')){
                $user->clearMediaCollection('user_image');
            }
             $user->addMedia($request->img)->toMediaCollection('user_image');
        }
        toast('Your Image has been updated!','success');
        return back();
        
    }

    public function user_password(Request $request,$id){
        // dd($request->current_password);
        $user=User::find($id);
        $request->validate([
            'current_password'=>'string|required',
            'new_password'=>'required|string',
            'confirm_password'=>['same:new_password'],
        ]);

        $currentPassword=Hash::checK($request->current_password,auth()->user()->password);
        if($currentPassword){
           $user->update([
                'password'=>Hash::make($request->new_password)
            ]);
             Alert::success('success', 'updated Password');
             return back();
         
        }else{
            Alert::error('Error', 'Something Went Wrong!');
            return back();
        }
    }

    public function post(){
        $category=Category::all();
        $post=Post::with('comments')->latest()->paginate(5);
        // $comments=Comment::all();
        
        return view('frontend.post.post',compact('category','post'));
    }
    public function home(){
        return view('frontend.post.main');
    }
}
