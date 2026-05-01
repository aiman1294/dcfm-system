<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseFile;
//use Illuminate\Support\Facades\Auth;


class CaseFileController extends Controller
{
   
    //
    public function create()
{
    return view('create');
}



public function index(Request $request)
{
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

public function store(Request $request)
{
    
    $validated = $request->validate([
        'case_title' =>'required|string|max:255',
        'case_description' => 'required|string',
        'case_priority' => 'required|in:low,medium,high',
    ]);

    \App\Models\CaseFile::create([
        'case_title' => $request->case_title,
        'case_description' => $request->case_description,
        'case_priority' => $request->case_priority,
        'case_status' => 'Open',
        'user_id' => \Illuminate\Support\Facades\Auth::id()
        //'user_id' => auth()->user()->id,
    ]);
    return redirect('/cases')->with('success', 'Case added!');
    
    
    

}
public function edit($id)
{
    $case = CaseFile::findOrFail($id);
     $isAdmin = auth()->user()->role === 'admin';
    $isOwner = $case->user_id === auth()->id();

    

    
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

    
    $validated = $request->validate([
        'case_title' =>'required|string|max:255',
        'case_description' => 'required|string',
        'case_priority' => 'required|in:low,medium,high',
    ]);
   
    

    
        if (!$isOwner && !$isAdmin)  {
        abort(403);
    }

    $case->update([
        'case_title' => $request->case_title,
        'case_description' => $request->case_description,
        'case_priority' => $request->case_priority,
        'case_status' => $case->case_status, // use later: 'case_status' => $request->case_status ?? $case->case_status
    ]);

    return redirect('/cases')->with('success', 'Case updated!');
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
public function show($id){
    $case = CaseFile::findOrFail($id);
    return view('show', compact('case'));
}
}
