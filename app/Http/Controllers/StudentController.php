<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return view('students.index');
    }

    public function data(Request $request)
    {
        return response()->json([]);
    }

    public function create()
    {
        return response('Create Student');
    }

    public function store(Request $request)
    {
        return response('Store Student');
    }

    public function edit(string $id)
    {
        return response('Edit Student');
    }

    public function update(Request $request, string $id)
    {
        return response('Update Student');
    }

    public function destroy(string $id)
    {
        return response('Delete Student');
    }

    public function export(Request $request)
    {
        return response('Export Student');
    }
}
