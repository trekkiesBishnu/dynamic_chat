<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likeStore($id){
       try {
          
      
       $like=Post::find($id);
       if($like){
         $like= Like::create([
              'user_id'=>Auth::id(),
              'post_id'=>$id,
          ]);
       }
       $count=Like::where('post_id',$id)->count();
       return response()->json([
          'success'=>true,
          'message'=>'liked success',
          'data'=>$like,
          'count'=>$count
       ]);
      } catch (\Throwable $th) {
         return response()->json([
            'success'=>true,
            'data'=>$th
         ]);
      }

    }
    public function likeDelete($id){
       try {
          $like=Like::where('post_id',$id)->where('user_id',Auth::id())->first();
          if($like){
             $like->delete();
             $count=Like::where('post_id',$id)->count();
             return response()->json([
               'success'=>true,
               'message'=>'dislike  success',
               'data'=>$like,
               'count'=>$count
            ]);
            }
         
       } catch (\Throwable $th) {
         return response()->json([
            'success'=>true,
            'data'=>$th
         ]);
       }
     

    }
}
