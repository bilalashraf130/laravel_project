<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ThinkTank extends Model
{
    use HasFactory;
    protected $table = 'think_thank';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'Thinking',
        'data',
        'information',
        'status',


    ];
    protected $casts = [
        'Thinking' 		     => 'string',
        'data'               => 'string',
        'information'        => 'string',
        'status'             => 'string',
    ];

    public function post(){
        return $this->hasOne(UserFormCount::class, 'user_id', 'user_id');
    }
}
