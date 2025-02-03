<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class TaskAssignmentController extends Controller
{

    public function assignTask(Request $request, $taskId)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($taskId);

        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $assignment = TaskAssignment::create([
            'task_id' => $task->id,
            'assigned_to' => $request->assigned_to,
            'assigned_by' => Auth::id(),
        ]);

        ActivityLog::create([
            'task_id' => $taskId,
            'performed_by' => Auth::id(),
            'activity' => 'Tugas diberikan kepada pengguna ' . $request->assigned_to,
        ]);

        Notification::create([
            'user_id' => $request->assigned_to,
            'task_id' => $task->id,
            'message' => 'Anda telah diberikan tugas baru: ' . $task->title,
        ]);

        return response()->json([
            'message' => 'Tugas berhasil diberikan',
            'assignment' => $assignment,
        ]);
    }


    public function getAssignedTasks()
    {
        $tasks = TaskAssignment::where('assigned_to', Auth::id())
            ->with('task')
            ->get();
        return response()->json(['tasks' => $tasks]);
    }
}
