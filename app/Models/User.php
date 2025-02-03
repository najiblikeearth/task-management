<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function assignedTasks()
    {
        return $this->hasMany(TaskAssignment::class, 'assigned_to');
    }

    public function taskStatusHistories()
    {
        return $this->hasMany(TaskStatusHistory::class, 'changed_by');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'performed_by');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
