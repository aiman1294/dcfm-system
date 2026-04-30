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
        'case_title' => $request->case_title
    ]);
    return redirect('/cases')->with('success', 'Case added!');
    

}
}
