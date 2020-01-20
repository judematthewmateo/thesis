<?php

namespace App\Models\Utilities;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'tb_clients';
    protected $primaryKey = 'client_id';
    public $timestamps = false;
}
