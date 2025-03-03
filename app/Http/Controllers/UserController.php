<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        Log::info('Fetched users:', ["data" => $users]); // Log the fetched users
        return response()->json(["data" => $users]);
    }
}
