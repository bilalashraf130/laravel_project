<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserNarrative extends Model
{
    use HasFactory;
    protected $table = 'user_narrative';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'narrative',
        'whats_on_your_mind',
        'thought_concern',
        'your_hope',
        'user_id',
        'status',
    ];
    protected $casts = [
        'narrative' 		 => 'string',
        'whats_on_your_mind' => 'string',
        'thought_concern'    => 'string',
        'your_hope'          => 'string',
        'status'             => 'string',
    ];

    public function post(){
        return $this->hasOne(UserFormCount::class, 'user_id', 'user_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
