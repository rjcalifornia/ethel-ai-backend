<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Querys extends Model
{
    use HasFactory;

    public function appId(){
        return $this->belongsTo(AuthorizedApps::class, 'app_id');
    }

}
