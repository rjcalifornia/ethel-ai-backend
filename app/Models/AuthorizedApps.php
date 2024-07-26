<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorizedApps extends Model
{
    use HasFactory;
    protected $table = 'authorized_apps';

    protected $fillable = [
        'name',
        'client_id',
        'api_key',
        'role_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

}

