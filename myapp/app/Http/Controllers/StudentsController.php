<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::where('active', true)->orderBy('name')->paginate(20);
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Студент успешно добавлен');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $attendances = $student->attendances()->orderBy('date', 'desc')->paginate(30);
        return view('students.show', compact('student', 'attendances'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Студент успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->update(['active' => false]);
        return redirect()->route('students.index')->with('success', 'Студент деактивирован');
    }
}
