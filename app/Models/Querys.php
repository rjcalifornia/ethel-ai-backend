<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Querys extends Model
{
    use HasFactory;

    protected $table = 'querys';

    protected $fillable = [
        'app_id',
        'prompt',
        'model_response',
        'prompt_token_count',
        'response_token_count',
        'total_tokens_used',
        'model_name',
    ];

    public function appId(){
        return $this->belongsTo(AuthorizedApps::class, 'app_id');
    }

}
