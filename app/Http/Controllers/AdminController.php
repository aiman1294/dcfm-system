<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class AdminController extends Controller
{

    public function __construct()
    {
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }
    }
        public function index()
    {
        $users = User::whereNotNull('requested_role')->get();
        return view('admin.requests', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);

        $user->role = $user->requested_role;
        $user->requested_role = null;
        $user->save();

        return redirect()->back()->with(
            'success',
            "Role {$user->role} assigned to {$user->name}"
        );
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);

        $user->requested_role = null;
        $user->role = 'pending';
        $user->save();

        return redirect()->back()->with(
            'error',
            "Role request rejected for {$user->name}"
        );
    }
}


