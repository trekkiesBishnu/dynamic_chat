<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function commentPost(Request $request ,$id){
       $post=Post::find($id);
       if($post){
           Comment::create([
                'user_id'=>Auth::id(),
                'post_id'=>$id,
                'comment'=>$request->comment,
           ]);
           return back();
       }
    }
    public function commentEdit($id){
        $user_comment=Comment::where('user_id',Auth::id())->where('id',$id)->first();
        dd($id);
        if($user_comment){
           return response()->json([
                'userComment'=>$user_comment,
           ]);
        }
    }

}
