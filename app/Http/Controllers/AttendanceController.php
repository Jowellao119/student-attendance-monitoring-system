<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Attendance;
use App\Models\Student;

class AttendanceController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('last_name')->get();

        $attendances = Attendance::with('student')
            ->latest('attendance_date')
            ->latest()
            ->get();

        return view('attendance.index', compact('students', 'attendances'));
    }

    public function history(Request $request)
    {
        $students = Student::orderBy('last_name')->get();

        $query = Attendance::with('student');

        if ($request->filled('from_date')) {
            $query->whereDate('attendance_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('attendance_date', '<=', $request->to_date);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $attendances = $query
            ->latest('attendance_date')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('attendance.history', compact(
            'students',
            'attendances'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:Present,Absent',
        ]);

        Attendance::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'attendance_date' => $validated['attendance_date'],
            ],
            [
                'status' => $validated['status'],
            ]
        );

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance saved successfully!');
    }

    public function edit(Attendance $attendance)
    {
        $students = Student::orderBy('last_name')->get();

        return view('attendance.edit', compact('attendance', 'students'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('attendances', 'student_id')
                    ->where(function ($query) use ($request) {
                        return $query->where(
                            'attendance_date',
                            $request->attendance_date
                        );
                    })
                    ->ignore($attendance->id),
            ],
            'attendance_date' => 'required|date',
            'status' => 'required|in:Present,Absent',
        ]);

        $attendance->update($validated);

        return redirect()->route('attendance.history')
            ->with('success', 'Attendance updated successfully!');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendance.history')
            ->with('success', 'Attendance deleted successfully!');
    }
}
