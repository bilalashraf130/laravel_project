<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MembershipForUser extends Model
{
    use HasFactory;
    protected $table = 'membership_type_for_user';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'membership_type',



    ];
    protected $casts = [
        'membership_type'               => 'string',

    ];

//    public function post(){
//        return $this->hasOne(UserFormCount::class, 'user_id', 'user_id');
//    }
}
