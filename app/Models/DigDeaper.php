<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DigDeaper extends Model
{
    use HasFactory;
    protected $table = 'dig_deeper';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'data',
        'information',
        'status',


    ];
    protected $casts = [
        'data'               => 'string',
        'information'        => 'string',
        'status'             => 'string',
    ];

    public function post(){
        return $this->hasOne(UserFormCount::class, 'user_id', 'user_id');
    }
}
