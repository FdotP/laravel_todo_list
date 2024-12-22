<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasksArch extends Model
{
    protected $fillable = ['name', 'description','priority','status','execution_date','user_id', 'task_id'] ;
}
