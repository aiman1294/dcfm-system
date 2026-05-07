<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseFile;
use App\Models\CaseLog;
//use Illuminate\Support\Facades\Auth;


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
    CaseLog::create([
    'case_file_id' => $case->id,
    'user_id' => auth()->id(),
    'action' => 'Assigned Judge'.$judge->name,
    ]);


    return back()->with('success', 'Judge assigned!');
}

public function index(Request $request)
{
    // if (auth()->user()->role === 'pending') {
    // return redirect('/')->with('error', 'Wait for admin approval');

    $user = auth()->user();
    $query = CaseFile::query();

    if ($user->role === 'pending') {
        abort(403); // or redirect if you prefer
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
    
    $validated = $request->validate([
        'case_title' =>'required|string|max:255',
        'case_description' => 'required|string',
        'case_priority' => 'required|in:low,medium,high',
        'case_status' => 'nullable|in:Open,In Progress,Closed',
    ]);

    $case = \App\Models\CaseFile::create([
        'case_title' => $request->case_title,
        'case_description' => $request->case_description,
        'case_priority' => $request->case_priority,
        'case_status' => $request->filled('case_status') ? $request->case_status : 'Open',
        'user_id' => \Illuminate\Support\Facades\Auth::id()

    ]);
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

    $isAdmin = auth()->user()->role === 'admin';
    $isOwner = $case->user_id === $user->id;
    $isAssignedJudge = $user->role === 'judge' && $case->judge_id === $user->id;

    
    if (!$isOwner && !$isAdmin && !$isAssignedJudge) 
        {
        abort(403); // forbidden
    }

    return view('edit', compact('case'));

}

// 
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

    $updateData = [];

    
    if ($isAdmin) {
        $validated = $request->validate([
            'case_title' => 'required|string|max:255',
            'case_description' => 'required|string',
            'case_priority' => 'required|in:low,medium,high',
            'case_status' => 'nullable|in:Open,In Progress,Closed',
            'judge_id' => 'nullable|exists:users,id',
        ]);

        $updateData = $validated;
        if (!empty($validated['judge_id'])) {

    $judge = \App\Models\User::find($validated['judge_id']);

    CaseLog::create([
        'case_file_id' => $case->id,
        'user_id' => auth()->id(),
        'action' => 'Assigned Judge ' . $judge->name,
    ]);
}
    }

    
    elseif ($isOwner) {
        $validated = $request->validate([
            'case_title' => 'required|string|max:255',
            'case_description' => 'required|string',
            'case_priority' => 'required|in:low,medium,high',
        ]);
        

        $updateData = $validated;
    }

    
    elseif ($isAssignedJudge) {
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
            'action' => 'Updated case status to '.$validated['case_status'],
        ]);
        if (!empty($validated['verdict'])) {

    CaseLog::create([
        'case_file_id' => $case->id,
        'user_id' => auth()->id(),
        'action' => 'Added verdict to the case',
    ]);
    }
    if (!empty($validated['hearing_date'])) {

    CaseLog::create([
        'case_file_id' => $case->id,
        'user_id' => auth()->id(),
        'action' => 'Scheduled hearing '.$validated['hearing_date'],
    ]);
    }   
        return redirect('/cases')->with('success', 'Case status updated!');
    }
 

    $case->update($updateData);

     return redirect('/cases')->with('success', 'Case updated!');
}

    // $validated = $request->validate([
    //     'case_title' => 'required|string|max:255',
    //     'case_description' => 'required|string',
    //     'case_priority' => 'required|in:low,medium,high',
    //     'case_status' => 'nullable|in:Open,In Progress,Closed',
    //     'judge_id' => 'nullable|exists:users,id',
    // ]);

    // $updateData = [];

   
    // if ($isAdmin) {
    //     $updateData = $validated;
    // }

    
    // elseif ($isOwner) {
    //     $updateData = [
    //         'case_title' => $validated['case_title'],
    //         'case_description' => $validated['case_description'],
    //         'case_priority' => $validated['case_priority'],
    //     ];
    // }

    
    // elseif ($isAssignedJudge && $request->filled('case_status')) {
    //     $updateData = [
    //         'case_status' => $validated['case_status'],
    //     ];
    // }

    // $case->update($updateData);

    // return redirect('/cases')->with('success', 'Case updated!');
    // }


public function destroy($id)
{
    $case = CaseFile::findOrFail($id);
     $isAdmin = auth()->user()->role === 'admin';
    $isOwner = $case->user_id === auth()->id();
    

    // if (auth()->user()->role === 'pending') {
    //     return redirect('/')->with('error', 'Wait for admin approval');
    // }
    
    if (!$isOwner && !$isAdmin) {
        abort(403);
    }

    $case->delete();

    return redirect('/cases')->with('success', 'Case deleted!');
}
public function show($id){
    $case = CaseFile::findOrFail($id);
    $user = auth()->user();
    //dd($case->logs);

    $isAdmin = $user->role === 'admin';
    $isOwner = $case->user_id === $user->id;
    $isAssignedJudge = $user->role === 'judge' && $case->judge_id === $user->id;

    if (!$isAdmin && !$isOwner && !$isAssignedJudge) {
        abort(403);
    }
    return view('show', compact('case'));
}
}
