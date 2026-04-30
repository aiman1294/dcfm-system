<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseFile;

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

    

    \App\Models\CaseFile::create([
        'case_title' => $request->case_title,
        'case_description' => $request->case_description,
        'case_priority' => $request->case_priority,
        'case_status' => 'Open',
    ]);
    return redirect('/cases')->with('success', 'Case added!');
    

}
public function edit($id)
{
    $case = CaseFile::findOrFail($id);
    return view('edit', compact('case'));
}

public function update(Request $request, $id)
{
    $case = CaseFile::findOrFail($id);

    $case->update([
        'case_title' => $request->case_title,
        'case_description' => $request->case_description,
        'case_priority' => $request->case_priority,
        'case_status' => $request->case_status,
    ]);

    return redirect('/cases')->with('success', 'Case updated!');
}
}
