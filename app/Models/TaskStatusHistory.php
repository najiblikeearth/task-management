<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'task_status_history';

    protected $fillable = [
        'task_id',
        'old_status',
        'new_status',
        'changed_by',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
