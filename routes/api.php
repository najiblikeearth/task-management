<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskAssignmentController;
use App\Http\Controllers\TaskStatusHistoryController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController; // Import the UserController

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        // Auth routes
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
    });

    Route::middleware('auth:sanctum')->group(function () {

        // Notification routes        
        Route::get('/notifications', [NotificationController::class, 'getUnreadNotifications']);
        Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);

        // Profile routes
        Route::post('/profile', [ProfileController::class, 'updateProfile']);
        Route::get('/profile', [AuthController::class, 'getUserProfile']);

        // Task routes
        Route::apiResource('tasks', TaskController::class);
        Route::put('/tasks/{id}/update-status', [TaskController::class, 'updateStatus']);


        // Task assignment routes
        Route::post('/tasks/{taskId}/assign', [TaskAssignmentController::class, 'assignTask']);
        Route::get('/my-assigned-tasks', [TaskAssignmentController::class, 'getMyAssignedTasks']);
        Route::get('/assigned-tasks', [TaskAssignmentController::class, 'getAssignedTasks']);


        // Task status history routes
        Route::get('/tasks/{taskId}/status-history', [TaskStatusHistoryController::class, 'getStatusHistory']);

        // Activity log routes
        Route::get('/tasks/{taskId}/activity-logs', [ActivityLogController::class, 'getActivityLogs']);

        // User routes
        Route::get('/users', [UserController::class, 'index']);
    });
});
