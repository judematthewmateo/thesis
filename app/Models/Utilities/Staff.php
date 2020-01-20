<?php

namespace App\Models\Utilities;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'tb_staffs';
    protected $primaryKey = 'staff_id';
    public $timestamps = false;
}
