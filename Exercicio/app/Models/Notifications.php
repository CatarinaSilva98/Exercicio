<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model{

    protected $primaryKey = 'id';

    protected $fillable = ['id_user', 'content'];


}
