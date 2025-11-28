<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendancesController extends Controller
{
    /**
     * Показать форму для отметки посещаемости на выбранную дату
     */
    public function today(Request $request)
    {
        $date = $request->get('date') ? Carbon::parse($request->get('date')) : Carbon::today();
        $students = Student::where('active', true)->orderBy('name')->get();
        $attendances = Attendance::where('date', $date)->pluck('status', 'student_id');

        return view('attendances.today', compact('students', 'attendances', 'date'));
    }

    /**
     * Сохранить посещаемость на выбранную дату
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*' => 'required|in:present,absent,late,excused'
        ]);

        $date = Carbon::parse($validated['date']);

        foreach ($validated['attendances'] as $studentId => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'date' => $date],
                ['status' => $status]
            );
        }

        return redirect()->back()->with('success', 'Посещаемость сохранена');
    }

    /**
     * Показать отчет по посещаемости
     */
    public function report(Request $request)
    {
        $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : Carbon::now()->endOfMonth();

        $students = Student::where('active', true)->with(['attendances' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }])->orderBy('name')->get();

        return view('attendances.report', compact('students', 'startDate', 'endDate'));
    }

    /**
     * Показать посещаемость конкретного студента
     */
    public function student(Student $student)
    {
        $attendances = $student->attendances()
            ->orderBy('date', 'desc')
            ->paginate(30);

        return view('attendances.student', compact('student', 'attendances'));
    }
}
