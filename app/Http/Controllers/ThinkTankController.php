<?php

namespace App\Http\Controllers;

use App\Models\ThinkTank;
use App\Models\UserFormCount;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ThinkTankController extends Controller
{
   public function show_form(){

       return view('thinktank')->with(['msg'=>'Enter ThinkTank']);
   }

   public function get_thinktank_data(Request $request){
       $data = $request->validate([
           "Thinking" => ["required", "string"],
           "data" => ["required", "string"],
           "information" => ["required", "string"],

       ]);
       $temp = ['user_id' => $request->user()->id,'status'=>'free'];
       $user_data = array_merge($temp, $data);
       try {
           $check = $this->authorize('Check_free_thinktank', ThinkTank::class);
           $Add_free_narrative = ThinkTank::create($user_data);
           return view('thinktank')->with(['msg'=>'Successfully Enter']);
       } catch (AuthorizationException $e) {
           $check_response = $e->response()->allowed();
           if($check_response == false){
               try {
                   $this->authorize('check_paid_thinktank', ThinkTank::class);
                   $temp = ['user_id' => $request->user()->id,'status'=>'product'];
                   $user_data = array_merge($temp, $data);
                   $Add_paid_thinktank = ThinkTank::create($user_data);
                   $get_count = UserFormCount::where('user_id',$request->user()->id)->where('key','thinktank')->get();
                   $count = $get_count[0]->count -1;
                   $get_count[0]->count = $count;
                   $get_count[0]->save();

                   return view('thinktank')->with(['msg'=>'Successfully Enter']);

               } catch (AuthorizationException $error){
                   $delete = UserFormCount::where('user_id',$request->user()->id)->where('key','thinktank');
                   $delete->delete();
                   return view('thinktank')->with(['msg'=>$error->getMessage()]);
               }
           }
       }
   }

    Public function Add_count_to_thinktank(Request $request){

        $user = $request->user();
        $get_data = UserFormCount::where('user_id',$user->id)->where('key','thinktank')->count();
        if($get_data == 0){
            $temp = ['user_id' => $user->id,'count'=>1,'key'=>'thinktank'];
            UserFormCount::create($temp);
        } else {

            $get_count = UserFormCount::where('user_id',$user->id)->where('key','thinktank')->get();
            $count = $get_count[0]->count +1;
            $get_count[0]->count = $count;
            $get_count[0]->save();

        }
        return redirect(route('show_thinktank_form'));

    }
}
