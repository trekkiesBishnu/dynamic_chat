<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likeStore(Request $request,$id){
    
       try {
          $data=$request->all();
         
       $like=Post::find($id);
     
       if($like){
        if($data['status']=="Like"){
         Like::create([
            'user_id'=>Auth::id(),
            'post_id'=>$id,
        ]);
        }
        if($data['status']=="Unlike"){
         Like::where('post_id',$id)->where('user_id',Auth::id())->delete();
        }
       }
       $count=Like::where('post_id',$id)->count();
       return response()->json([
          'success'=>true,
          'message'=>$data['status'].' success',
          'data'=>$like,
          'count'=>$count,
          'text'=>$data['status']=="Like"?"Unlike":"Like"
         //  'access'=>$premission,
       ]);
      } catch (\Throwable $th) {
         return response()->json([
            'success'=>true,
            'data'=>$th,
           
         ]);
      }

    }
  
     

    
}
