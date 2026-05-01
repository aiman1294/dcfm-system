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



public function index()
{
    $cases = CaseFile::all();
   


    return view('index', compact('cases'));
    
}

public function store(Request $request)
{
    //dd('HELLO I AM RUNNING', \Illuminate\Support\Facades\Auth::id());
    

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
     $isAdmin = auth()->user()->role === 'admin';
    $isOwner = $case->user_id === auth()->id();

    $case = CaseFile::findOrFail($id);

    // if ($case->user_id !== auth()->id() &&
    //     auth()->user()->role !== 'admin')
    if (!$isOwner && !$isAdmin) 
        {
        abort(403); // forbidden
    }

    return view('edit', compact('case'));

}

public function update(Request $request, $id)
{
     $isAdmin = auth()->user()->role === 'admin';
    $isOwner = $case->user_id === auth()->id();
   
    $case = CaseFile::findOrFail($id);

    // if ($case->user_id !== auth()->id() &&
    //     auth()->user()->role !== 'admin')
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
     $isAdmin = auth()->user()->role === 'admin';
    $isOwner = $case->user_id === auth()->id();
    $case = CaseFile::findOrFail($id);

    // if ($case->user_id !== auth()->id() &&
    //     auth()->user()->role !== 'admin') 
    if (!$isOwner && !$isAdmin) {
        abort(403);
    }

    $case->delete();

    return redirect('/cases')->with('success', 'Case deleted!');
}
}
