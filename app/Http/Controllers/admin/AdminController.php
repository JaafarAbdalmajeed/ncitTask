<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
    public function index()
    {
        $users = User::where('type', 'student')->get();
        return view('admin.index', compact('users'));
    }
}
