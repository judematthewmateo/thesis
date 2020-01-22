<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usertype extends Model
{
    protected $table = 'refusertype';
    protected $primaryKey = 'user_type_id';
    public $timestamps = false;
}
