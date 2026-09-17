<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Institution;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        // Prepared statement query to fetch institutions for the filter dropdown
        $institutions = DB::select('SELECT id, name FROM institutions ORDER BY name ASC');

        return view('students.index', compact('institutions'));
    }

    public function data(Request $request)
    {
        // We will build full DataTables AJAX response in Task 5
        return response()->json(['data' => []]);
    }

    public function create(): View
    {
        $institutions = DB::select('SELECT id, name FROM institutions ORDER BY name ASC');

        return view('students.create', compact('institutions'));
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('students', 'public');
        }

        // Use Prepared Statement via Query Builder / Eloquent binding
        DB::transaction(function () use ($validated, $photoPath) {
            DB::insert(
                'INSERT INTO students (institution_id, nis, name, email, photo, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)',
                [
                    $validated['institution_id'],
                    $validated['nis'],
                    $validated['name'],
                    $validated['email'],
                    $photoPath,
                    now(),
                    now(),
                ]
            );
        });

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student): View
    {
        $institutions = DB::select('SELECT id, name FROM institutions ORDER BY name ASC');

        return view('students.edit', compact('student', 'institutions'));
    }

    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        $validated = $request->validated();

        $photoPath = $student->photo;

        if ($request->hasFile('photo')) {
            if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo')->store('students', 'public');
        }

        // Use Prepared Statement
        DB::transaction(function () use ($validated, $photoPath, $student) {
            DB::update(
                'UPDATE students SET institution_id = ?, nis = ?, name = ?, email = ?, photo = ?, updated_at = ? WHERE id = ?',
                [
                    $validated['institution_id'],
                    $validated['nis'],
                    $validated['name'],
                    $validated['email'],
                    $photoPath,
                    now(),
                    $student->id,
                ]
            );
        });

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $photo = $student->photo;

        DB::transaction(function () use ($student) {
            DB::delete('DELETE FROM students WHERE id = ?', [$student->id]);
        });

        if ($photo && Storage::disk('public')->exists($photo)) {
            Storage::disk('public')->delete($photo);
        }

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function export(Request $request)
    {
        return response('Exported');
    }
}
