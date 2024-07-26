<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppTokens extends Model
{
    use HasFactory;
    protected $table = 'app_tokens';

    protected $fillable = [
        'app_id',
        'tokens_allocated',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function appId(){
        return $this->belongsTo(AuthorizedApps::class, 'app_id');
    }
}
