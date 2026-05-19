<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseFile;
use App\Models\CaseLog;

class CaseFileController extends Controller
{
    public function assignJudge(Request $request, $id)
    {
        $case = CaseFile::findOrFail($id);

        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'judge_id' => 'required|exists:users,id'
        ]);

        $case->judge_id = $request->judge_id;
        $case->save();

        $judge = \App\Models\User::find($request->judge_id);

        sendNotification(
            $judge->id,
            "You have been assigned to Case #{$case->id}",
            "/cases/{$case->id}"
        );

        sendNotification(
            $case->user_id,
            "Judge {$judge->name} has been assigned to Case #{$case->id}",
            "/cases/{$case->id}"
        );

        CaseLog::create([
            'case_file_id' => $case->id,
            'user_id' => auth()->id(),
            'action' => 'Assigned Judge ' . $judge->name,
        ]);

        return back()->with('success', 'Judge assigned!');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = CaseFile::query();

        if ($user->role === 'pending') {
            abort(403);
        }

        if ($user->role === 'lawyer') {
            $query->where('user_id', $user->id);
        }

        if ($user->role === 'judge') {
            $query->where('judge_id', $user->id);
        }

        if ($request->filled('priority')) {
            $query->where('case_priority', $request->priority);
        }

        if ($request->filled('status')) {
            $query->where('case_status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('case_title', 'like', '%' . $request->search . '%')
                  ->orWhere('case_description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'latest') {
                $query->latest();
            } elseif ($request->sort === 'oldest') {
                $query->oldest();
            } elseif ($request->sort === 'priority') {
                $query->orderBy('case_priority');
            }
        }

        $cases = $query->paginate(5)->withQueryString();

        return view('index', compact('cases'));
    }

    public function create()
    {
        if (!in_array(auth()->user()->role, ['lawyer', 'admin'])) {
            abort(403);
        }

        return view('create');
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['lawyer', 'admin'])) {
            abort(403);
        }

        $request->validate([
            'case_title' => 'required|string|max:255',
            'case_description' => 'required|string',
            'case_priority' => 'required|in:low,medium,high',
            'case_status' => 'nullable|in:Open,In Progress,Closed',
        ]);

        $case = CaseFile::create([
            'case_title' => $request->case_title,
            'case_description' => $request->case_description,
            'case_priority' => $request->case_priority,
            'case_status' => $request->filled('case_status') ? $request->case_status : 'Open',
            'user_id' => auth()->id(),
        ]);

        $admins = \App\Models\User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            sendNotification(
                $admin->id,
                "New case filed: Case #{$case->id}",
                "/cases/{$case->id}"
            );
        }

        CaseLog::create([
            'case_file_id' => $case->id,
            'user_id' => auth()->id(),
            'action' => 'New Case Created.',
        ]);

        return redirect('/cases')->with('success', 'Case added!');
    }

    public function edit($id)
    {
        $case = CaseFile::findOrFail($id);
        $user = auth()->user();

        $isAdmin = $user->role === 'admin';
        $isOwner = $case->user_id === $user->id;
        $isAssignedJudge = $user->role === 'judge' && $case->judge_id === $user->id;

        if (!$isOwner && !$isAdmin && !$isAssignedJudge) {
            abort(403);
        }

        return view('edit', compact('case'));
    }

    public function update(Request $request, $id)
    {
        $case = CaseFile::findOrFail($id);
        $user = auth()->user();

        $isAdmin = $user->role === 'admin';
        $isOwner = $case->user_id === $user->id;
        $isAssignedJudge = $user->role === 'judge' && $case->judge_id === $user->id;

        if (!$isOwner && !$isAdmin && !$isAssignedJudge) {
            abort(403);
        }

        if ($isAdmin) {
            $validated = $request->validate([
                'case_title' => 'required|string|max:255',
                'case_description' => 'required|string',
                'case_priority' => 'required|in:low,medium,high',
                'case_status' => 'nullable|in:Open,In Progress,Closed',
                'judge_id' => 'nullable|exists:users,id',
            ]);

            $case->update($validated);

            if (!empty($validated['judge_id'])) {
                $judge = \App\Models\User::find($validated['judge_id']);

                CaseLog::create([
                    'case_file_id' => $case->id,
                    'user_id' => auth()->id(),
                    'action' => 'Assigned Judge ' . $judge->name,
                ]);

                sendNotification(
                    $judge->id,
                    "You have been assigned to Case #{$case->id}",
                    "/cases/{$case->id}"
                );

                sendNotification(
                    $case->user_id,
                    "Judge {$judge->name} has been assigned to Case #{$case->id}",
                    "/cases/{$case->id}"
                );
            }

            return redirect('/cases')->with('success', 'Case updated!');
        }

        if ($isOwner) {
            $validated = $request->validate([
                'case_title' => 'required|string|max:255',
                'case_description' => 'required|string',
                'case_priority' => 'required|in:low,medium,high',
            ]);

            $case->update($validated);

            return redirect('/cases')->with('success', 'Case updated!');
        }

        if ($isAssignedJudge) {
            $validated = $request->validate([
                'case_status' => 'required|in:Open,In Progress,Closed',
                'hearing_date' => 'nullable|date',
                'judge_notes' => 'nullable|string',
                'verdict' => 'nullable|string',
            ]);

            $case->update([
                'case_status' => $validated['case_status'],
                'hearing_date' => $validated['hearing_date'],
                'judge_notes' => $validated['judge_notes'],
                'verdict' => $validated['verdict'],
            ]);

            CaseLog::create([
                'case_file_id' => $case->id,
                'user_id' => auth()->id(),
                'action' => 'Updated case status to ' . $validated['case_status'],
            ]);

            sendNotification(
                $case->user_id,
                "Case #{$case->id} status updated to {$validated['case_status']}",
                "/cases/{$case->id}"
            );

            if (!empty($validated['verdict'])) {
                CaseLog::create([
                    'case_file_id' => $case->id,
                    'user_id' => auth()->id(),
                    'action' => 'Added verdict to the case',
                ]);

                sendNotification(
                    $case->user_id,
                    "Verdict added to Case #{$case->id}",
                    "/cases/{$case->id}"
                );
            }

            if (!empty($validated['hearing_date'])) {
                CaseLog::create([
                    'case_file_id' => $case->id,
                    'user_id' => auth()->id(),
                    'action' => 'Scheduled hearing ' . $validated['hearing_date'],
                ]);

                sendNotification(
                    $case->user_id,
                    "Hearing scheduled for Case #{$case->id} on {$validated['hearing_date']}",
                    "/cases/{$case->id}"
                );
            }

            if (!empty($validated['judge_notes'])) {
                CaseLog::create([
                    'case_file_id' => $case->id,
                    'user_id' => auth()->id(),
                    'action' => 'Added judge notes',
                ]);

                sendNotification(
                    $case->user_id,
                    "Judge added notes to Case #{$case->id}",
                    "/cases/{$case->id}"
                );
            }

            return redirect('/cases')->with('success', 'Case status updated!');
        }
    }

    public function destroy($id)
    {
        $case = CaseFile::findOrFail($id);

        $isAdmin = auth()->user()->role === 'admin';
        $isOwner = $case->user_id === auth()->id();

        if (!$isOwner && !$isAdmin) {
            abort(403);
        }

        $case->delete();

        return redirect('/cases')->with('success', 'Case deleted!');
    }

    public function show($id)
    {
        $case = CaseFile::findOrFail($id);
        $user = auth()->user();

        $isAdmin = $user->role === 'admin';
        $isOwner = $case->user_id === $user->id;
        $isAssignedJudge = $user->role === 'judge' && $case->judge_id === $user->id;

        if (!$isAdmin && !$isOwner && !$isAssignedJudge) {
            abort(403);
        }

        return view('show', compact('case'));
    }
}