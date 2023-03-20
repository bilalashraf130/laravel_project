<?php

namespace App\Http\Controllers;

use App\Models\DigDeaper;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\UserFormCount;
class DIgDeaperController extends Controller
{
    public function show_form(){

        return view('digdeaper')->with(['msg'=>'Enter DigDeaper']);
    }

    public function get_digdeaper_data(Request $request){
        $data = $request->validate([
            "data" => ["required", "string"],
            "information" => ["required", "string"],

        ]);
        $temp = ['user_id' => $request->user()->id,'status'=>'free'];
        $user_data = array_merge($temp, $data);
        try {
            $check = $this->authorize('Check_free_digdeaper', DigDeaper::class);
            $Add_free_narrative = DigDeaper::create($user_data);
            return view('digdeaper')->with(['msg'=>'Successfully Enter']);
        } catch (AuthorizationException $e) {
            $check_response = $e->response()->allowed();
            if($check_response == false){
                try {
                    $this->authorize('check_paid_digdeaper', DigDeaper::class);
                    $temp = ['user_id' => $request->user()->id,'status'=>'product'];
                    $user_data = array_merge($temp, $data);
                    $Add_paid_digdeaper = DigDeaper::create($user_data);
                    $get_count = UserFormCount::where('user_id',$request->user()->id)->where('key','digdeaper')->get();
                    $count = $get_count[0]->count -1;
                    $get_count[0]->count = $count;
                    $get_count[0]->save();

                    return view('digdeaper')->with(['msg'=>'Successfully Enter']);

                } catch (AuthorizationException $error){
                    $delete = UserFormCount::where('user_id',$request->user()->id)->where('key','digdeaper');
                    $delete->delete();
                    return view('digdeaper')->with(['msg'=>$error->getMessage()]);
                }
            }
        }
    }
    Public function Add_count_to_digdeaper(Request $request){

        $user = $request->user();
        $get_data = UserFormCount::where('user_id',$user->id)->where('key','digdeaper')->count();
        if($get_data == 0){
            $temp = ['user_id' => $user->id,'count'=>1,'key'=>'digdeaper'];
            UserFormCount::create($temp);
        } else {

            $get_count = UserFormCount::where('user_id',$user->id)->where('key','digdeaper')->get();
            $count = $get_count[0]->count +1;
            $get_count[0]->count = $count;
            $get_count[0]->save();

        }
        return redirect(route('show_digdeaper_form'));

    }
}
