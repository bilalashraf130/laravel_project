<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserNarrative;


class UserFormCount extends Model
{
    use HasFactory;
    protected $table = 'user_form_count';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'count',
        'key',
        'hash_key',
    ];
}
