<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DigDeaper;
use Illuminate\Auth\Access\HandlesAuthorization;

class DigDeaperPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function Check_free_digdeaper(User $user)
    {
        $check_free = DigDeaper::where('user_id', $user->id)->where('status','free')->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count();
        if($check_free < 2) {

            return true;

        }
    }

    public function check_paid_digdeaper(User $user){

        $check_free = DigDeaper::where('user_id', $user->id)->where('status','free')->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count();

        if($check_free == 2) {

            $data = DigDeaper::with('post')->where('user_id',$user->id)->get();
            if($data[0]->post == null){
                return false;
            }
            else if($data[0]->post->count != 0) {
                return true;
            }
        }
    }

}
