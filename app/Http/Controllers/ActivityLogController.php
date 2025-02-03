<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function getActivityLogs($taskId)
    {
        $logs = ActivityLog::where('task_id', $taskId)->get();
        return response()->json(['logs' => $logs]);
    }
}
