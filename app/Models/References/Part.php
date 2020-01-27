<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $table = 'tb_parts';
    protected $primaryKey = 'part_id';
    public $timestamps = false;
}
