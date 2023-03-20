<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserFormCount;
use App\Models\UserNarrative;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use http\Env\Request;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserNarrativePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function Check_free_narrative(User $user)
    {
        $check_free = UserNarrative::where('user_id', $user->id)->where('status','free')->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count();

        if($check_free < 2) {

            return true;

        }
    }

    public function check_paid_narrative(User $user){

        $check_free = UserNarrative::where('user_id', $user->id)->where('status','free')->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count();
        if($check_free == 2) {
            $key = md5('narrative'.$user->id);
//            $userFormCount = Cache::remember('user_narrative501'.$user->id, 5 * 60, function () use ($user,$key ) {
//
//                return UserFormCount::where('hash_key',$key)->get();
//
//            });
            $userFormCount = UserFormCount::where('hash_key',$key)->get();
            if(isset($userFormCount[0]->count)){
                if($userFormCount[0]->count == 0) {
                    return false;
                } else {
                   return true;
                }
            } else {
                return false;

            }
        }
    }
}
