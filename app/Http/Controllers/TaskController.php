<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskStatusHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Tugas berhasil dibuat', 'task' => $task], 201);
    }

    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return response()->json(['tasks' => $tasks]);
    }

    public function show($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        return response()->json(['task' => $task]);
    }

    public function update(Request $request, $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'sometimes|date',
        ]);

        $task->update($request->only(['title', 'description', 'due_date']));

        if ($task->wasChanged()) {
            ActivityLog::create([
                'task_id' => $id,
                'performed_by' => Auth::id(),
                'activity' => 'Detail tugas diperbarui',
            ]);
        }

        return response()->json(['message' => 'Tugas berhasil diperbarui', 'task' => $task]);
    }

    public function destroy($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        ActivityLog::create([
            'task_id' => $task->id,
            'performed_by' => Auth::id(),
            'activity' => 'Task deleted',
        ]);

        $task->delete();

        return response()->json(['message' => 'Tugas berhasil dihapus']);
    }

    public function updateStatus(Request $request, $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,in progress,completed',
        ]);

        if ($task->status === 'pending' && $request->status === 'completed') {
            return response()->json([
                'message' => 'Status tidak bisa langsung berubah dari Pending ke Completed tanpa melewati In Progress.',
            ], 400);
        }

        if ($task->status === $request->status) {
            return response()->json([
                'message' => 'Status tidak berubah.',
            ], 400);
        }

        $oldStatus = $task->status;
        $task->status = $request->status;
        $task->save();

        TaskStatusHistory::create([
            'task_id' => $id,
            'old_status' => $oldStatus,
            'new_status' => $request->status,
            'changed_by' => Auth::id(),
        ]);

        ActivityLog::create([
            'task_id' => $id,
            'performed_by' => Auth::id(),
            'activity' => 'Status tugas berubah dari ' . $oldStatus . ' ke ' . $request->status,
        ]);

        return response()->json(['message' => 'Status tugas berhasil diperbarui', 'task' => $task]);
    }
}
