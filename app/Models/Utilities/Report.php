<?php

namespace App\Models\Utilities;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'tb_reports';
    protected $primaryKey = 'report_id';
    public $timestamps = false;
}
