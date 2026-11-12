<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = ['username', 'email', 'password', 'role', 'status'];
    protected $hidden = ['password'];
}