<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $data=[1,2,3,4,5];
        $users=User::all();
        return  response()->json([
            'success'=>true,
            'view'=>view('random',compact('users'))->render()
        ]);
    }

    public function userImage($id){
        // dd($id);
        $user=User::find($id);
        if($user){
            return response()->json([
                'success'=>true,
                'view'=>view('random_user',compact('user'))->render()
                
            ]);
        }
    }

    public function edit($id){
        $user=User::find($id);
        return response()->json([
            'data'=>$user,
            'success'=>true
        ]);
    }

    public function update(Request $request,$id){
       $data= $request->all();
        // dd($data['img']);
        $user=User::find($id);
        if(!$user){
            return response()->json([
                'data'=>'user not found'
            ]);
        }
        if($user){
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
            ]);
            if($user->hasMedia('user_image')){
                $user->clearMediaCollection('user_image');
            }
             $user->addMedia($request->img)->toMediaCollection('user_image');
             Alert::success('Success Title', 'Success Message');
             return response()->json([
                'data'=>$user,
                'message'=>'user Updated successfully',
                'success'=>true
            ]);
            
        }
        
    }

    public function userView(){
        $user=User::find(Auth::id());
        if($user){
            return response()->json([
                'success'=>true,
                'view'=>view('userView',compact('user'))->render()
            ]);
        }

    }
}
