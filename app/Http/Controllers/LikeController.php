<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likeStore($id){
       $like=Post::find($id);
       if($like){
          Like::create([
              'user_id'=>Auth::id(),
              'post_id'=>$id,
          ]);
       }
       return back();

    }
    public function likeDelete($id){
       $like=Like::where('post_id',$id)->where('user_id',Auth::id())->first();
       if($like){
               $like->delete();
          return back();
       }else{
           return back();
       }
     

    }
}
