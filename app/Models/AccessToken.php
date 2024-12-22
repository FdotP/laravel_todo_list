<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AccessToken extends Model
{
    use HasFactory;
    protected $fillable = ['task_id', 'token', 'expires_at'];

    public function task()
    {
        return $this->belongsTo(Tasks::class);
    }
}
