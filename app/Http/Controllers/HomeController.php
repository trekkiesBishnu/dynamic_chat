<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

    public function edit($id){
        $user=User::with('media')->find($id);
        return response()->json([
            'data'=>$user,
            'success'=>true
        ]);
    }

    public function update(Request $request,$id){
        $data=$request->all();
        dd($request->all());
        $user=User::find($id);
        if($user){
            $user->update($data);
            // $user->update([
            //     'name'=>$data['name'],
            //     'email'=>$data['email'],
            // ]);

            if($user->hasMedia('user_image')){
                $user->clearMediaCollection('user_image');
            }
            $user->addMedia($data['image'])->toMediaCollection('user_image');
            return response()->json([
                'data'=>$user,
                'message'=>'User Updated successfully',
                'success'=>true
            ]);
        }
    }
}
