<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseFile;
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

    return back()->with('success', 'Judge assigned!');
}

public function index(Request $request)
{
    // if (auth()->user()->role === 'pending') {
    // return redirect('/')->with('error', 'Wait for admin approval');


    $query = CaseFile::query();
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
    //  if (auth()->user()->role === 'pending') {
    //     return redirect('/')->with('error', 'Wait for admin approval');
    // }
    return view('create');
}

public function store(Request $request)
{
    // if (auth()->user()->role === 'pending') {
    //     return redirect('/')->with('error', 'Wait for admin approval');
    // }
    
    $validated = $request->validate([
        'case_title' =>'required|string|max:255',
        'case_description' => 'required|string',
        'case_priority' => 'required|in:low,medium,high',
        'case_status' => 'nullable|in:Open,In Progress,Closed',
    ]);

    \App\Models\CaseFile::create([
        'case_title' => $request->case_title,
        'case_description' => $request->case_description,
        'case_priority' => $request->case_priority,
        'case_status' => $request->filled('case_status') ? $request->case_status : 'Open',
        'user_id' => \Illuminate\Support\Facades\Auth::id()

    ]);
    return redirect('/cases')->with('success', 'Case added!');
    
    
    

}
public function edit($id)
{
    $case = CaseFile::findOrFail($id);
     $isAdmin = auth()->user()->role === 'admin';
    $isOwner = $case->user_id === auth()->id();

    // if (auth()->user()->role === 'pending') {
    //     return redirect('/')->with('error', 'Wait for admin approval');
    // }
    
    if (!$isOwner && !$isAdmin) 
        {
        abort(403); // forbidden
    }

    return view('edit', compact('case'));

}

public function update(Request $request, $id)
{

    

    $case = CaseFile::findOrFail($id);

    $isAdmin = auth()->user()->role === 'admin';
    $isOwner = $case->user_id === auth()->id();

      if (!$isOwner && !$isAdmin)  {
        abort(403);
    }
    if ($isAdmin && $request->filled('judge_id')) {
    $updateData['judge_id'] = $request->judge_id;

    
    $validated = $request->validate([
        'case_title' =>'required|string|max:255',
        'case_description' => 'required|string',
        'case_priority' => 'required|in:low,medium,high',
        'case_status' => 'nullable|in:Open,In Progress,Closed',
    ]);
   
    

    $updateData =[
        'case_title' => $request->case_title,
        'case_description' => $request->case_description,
        'case_priority' => $request->case_priority, 
    ];
    $isAdmin = auth()->user()->role === 'admin';

if ($isAdmin && $request->filled('judge_id')) {
    $updateData['judge_id'] = $request->judge_id;
}
    
}
    if(in_array(auth()->user()->role, ['judge','admin']) && $request->filled('case_status')) {
        $updateData['case_status']= $request->case_status;
    }

    $case->update($updateData);
        
    

    return redirect('/cases')->with('success', 'Case updated!');
}

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
    return view('show', compact('case'));
}
}
