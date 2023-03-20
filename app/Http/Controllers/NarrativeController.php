<?php

namespace App\Http\Controllers;
use App\Models\UserNarrative;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\UserFormCount;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class NarrativeController extends Controller
{
   public function show_form(){

       return view('narrative')->with(['msg'=>'Enter Narrative']);
   }

   public function get_narrative_data(Request $request){

       $data = $request->validate([
           "narrative" => ["required", "string"],
           "whats_on_your_mind" => ["required", "string"],
           "thought_concern" => ["required", "string"],
           "your_hope" => ["required", "string"],

       ]);
       $temp = ['user_id' => $request->user()->id,'status'=>'free'];
       $user_data = array_merge($temp, $data);
       try {
           $this->authorize('Check_free_narrative', UserNarrative::class);
           $start = microtime(true);
           $Add_free_narrative = UserNarrative::create($user_data);
           $end = microtime(true);
           $time = round(($end - $start) * 1000, 2);
           dump("Query free executed in {$time} ms");
           return view('narrative')->with(['msg'=>'Successfully Enter']);
       } catch (AuthorizationException $e) {
           $check_response = $e->response()->allowed();
           if($check_response == false){
               try {
                   $this->authorize('check_paid_narrative', UserNarrative::class);
                   $key = md5('narrative'.$request->user()->id);
                   $temp = ['user_id' => $request->user()->id,'status'=>'product'];
                   $user_data = array_merge($temp, $data);
                   $start = microtime(true);
                   $Add_paid_narrative = UserNarrative::create($user_data);
                   $end = microtime(true);
                   $time = round(($end - $start) * 1000, 2);
                   dump("Query Paid executed in {$time} ms");
                   $get_count = UserFormCount::where('hash_key',$key)->get();
                   $count = $get_count[0]->count -1;
                   $get_count[0]->count = $count;
                   $get_count[0]->save();
//                   Cache::put('user_narrative501'.$request->user()->id, $get_count, 10 * 60);

                   return view('narrative')->with(['msg'=>'Successfully Enter']);

               } catch (AuthorizationException $error){
                   return view('narrative')->with(['msg'=>$error->getMessage()]);
               }
           }
       }
   }

//   Public function Add_count_to_narrative(Request $request){
//
//       $user = $request->user();
//       $get_data = UserFormCount::where('user_id',$user->id)->where('key','narrative')->count();
//       if($get_data == 0){
//           $temp = ['user_id' => $user->id,'count'=>1,'key'=>'narrative'];
//           $data =  UserFormCount::create($temp);
//           Cache::has('usercount0007') ?   Cache::put('usercount0007'.$request->user()->id, $data, 10 * 60): '';
//
//       } else {
//
//           $get_count = UserFormCount::where('user_id',$user->id)->where('key','narrative')->get();
//           $count = $get_count[0]->count +1;
//           $get_count[0]->count = $count;
//           $get_count[0]->save();
//           Cache::has('usercount0007') ?   Cache::put('usercount0007'.$request->user()->id, $get_count, 10 * 60): '';
//       }
//       return redirect(route('show_form'));
//
//   }
}
