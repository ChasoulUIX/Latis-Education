<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Institution;
use App\Models\Student;
use App\Services\ImageCompressor;
use Illuminate\Http\JsonResponse;
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

        // Total stats for dashboard KPI overview cards
        $totalStudents = DB::scalar('SELECT COUNT(*) FROM students');
        $latisCount = DB::scalar("SELECT COUNT(s.id) FROM students s JOIN institutions i ON s.institution_id = i.id WHERE i.name LIKE '%Latis%'");
        $tutorCount = DB::scalar("SELECT COUNT(s.id) FROM students s JOIN institutions i ON s.institution_id = i.id WHERE i.name LIKE '%Tutor%'");

        return view('students.index', compact('institutions', 'totalStudents', 'latisCount', 'tutorCount'));
    }

    public function data(Request $request): JsonResponse
    {
        $institutionId = $request->query('institution_id');

        // Handle search keyword from either custom param or DataTables default
        $search = $request->query('search');
        if (is_array($search)) {
            $search = $search['value'] ?? null;
        }

        $sql = 'SELECT s.id, s.institution_id, s.nis, s.name, s.email, s.photo, s.created_at, i.name as institution_name
                FROM students s
                JOIN institutions i ON s.institution_id = i.id
                WHERE 1=1';
        $bindings = [];

        if (!empty($institutionId)) {
            $sql .= ' AND s.institution_id = ?';
            $bindings[] = $institutionId;
        }

        if (!empty($search)) {
            // Strictly search only on NIS & Name
            $sql .= ' AND (s.nis LIKE ? OR s.name LIKE ?)';
            $bindings[] = '%' . $search . '%';
            $bindings[] = '%' . $search . '%';
        }

        $sql .= ' ORDER BY s.created_at DESC';

        // Execute prepared statement
        $students = DB::select($sql, $bindings);

        $data = [];
        $no = 1;
        foreach ($students as $student) {
            $photoUrl = $student->photo
                ? asset('storage/' . $student->photo)
                : null;

            $editUrl = route('students.edit', $student->id);
            $deleteUrl = route('students.destroy', $student->id);
            $csrf = csrf_token();

            $actions = '
                <div class="flex items-center justify-center gap-1.5">
                    <a href="' . $editUrl . '" title="Edit Siswa" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold rounded-xl text-blue-700 bg-blue-50/80 border border-blue-200/80 hover:bg-blue-600 hover:text-white hover:border-blue-600 shadow-sm transition-all transform active:scale-95">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        <span>Edit</span>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data siswa ini?\')" class="inline">
                        <input type="hidden" name="_token" value="' . $csrf . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" title="Hapus Siswa" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold rounded-xl text-rose-700 bg-rose-50/80 border border-rose-200/80 hover:bg-rose-600 hover:text-white hover:border-rose-600 shadow-sm transition-all transform active:scale-95">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
            ';

            $data[] = [
                'no' => $no++,
                'id' => $student->id,
                'nis' => $student->nis,
                'name' => $student->name,
                'email' => $student->email,
                'institution_name' => $student->institution_name,
                'institution_id' => $student->institution_id,
                'photo' => $student->photo,
                'photo_url' => $photoUrl,
                'actions' => $actions,
            ];
        }

        return response()->json([
            'draw' => (int) $request->query('draw', 1),
            'recordsTotal' => count($data),
            'recordsFiltered' => count($data),
            'data' => $data,
        ]);
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
            $photoPath = ImageCompressor::compressAndStore($request->file('photo'), 'students', 'public');
        }

        // Prepared Statement via DB::insert
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
            $photoPath = ImageCompressor::compressAndStore($request->file('photo'), 'students', 'public');
        }

        // Prepared Statement via DB::update
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
        $institutionId = $request->query('institution_id');
        $search = $request->query('search');

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\StudentsExport($institutionId, $search),
            'data-siswa.xlsx'
        );
    }
}
