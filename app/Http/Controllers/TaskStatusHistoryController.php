<?php

namespace App\Http\Controllers;

use App\Models\TaskStatusHistory;

class TaskStatusHistoryController extends Controller
{
    public function getStatusHistory($taskId)
    {
        $history = TaskStatusHistory::where('task_id', $taskId)->get();
        return response()->json(['history' => $history]);
    }
}
