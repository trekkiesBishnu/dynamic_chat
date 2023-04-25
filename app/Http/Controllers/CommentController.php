<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function commentPost(Request $request ,$id){
        $comments=Comment::all();
       $post=Post::find($id);
       if($post){
          $comment= Comment::create([
                'user_id'=>Auth::id(),
                'post_id'=>$id,
                'comment'=>$request->comment,
           ]);
          return response()->json([
              'status'=>true,
              'message'=>'Comment Added successfully',
              'data'=>$comments,
             
          ]);
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

    public function commentUpdate($id){
        dd($id);
    }

}
