<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        // SUMMARY CARDS
        $totalStudents = Student::count();

        $presentToday = Attendance::where('attendance_date', $today)
            ->where('status', 'Present')
            ->count();

        $absentToday = Attendance::where('attendance_date', $today)
            ->where('status', 'Absent')
            ->count();

        $totalAttendanceToday = $presentToday + $absentToday;

        $attendanceRate = $totalAttendanceToday > 0
            ? round(($presentToday / $totalAttendanceToday) * 100, 1)
            : 0;

        // RECENT ATTENDANCE RECORDS
        $recentAttendances = Attendance::with('student')
            ->latest('attendance_date')
            ->latest()
            ->take(5)
            ->get();

        // WEEKLY ATTENDANCE DATA
        $weekStart = now()->startOfWeek();
        $weekEnd = $weekStart->copy()->endOfWeek();

        $weeklyRecords = Attendance::selectRaw(
            'attendance_date, status, COUNT(*) as total'
        )
            ->whereBetween('attendance_date', [
                $weekStart->toDateString(),
                $weekEnd->toDateString()
            ])
            ->groupBy('attendance_date', 'status')
            ->get();

        $weeklyCounts = [];

        foreach ($weeklyRecords as $record) {
            $weeklyCounts[$record->attendance_date][$record->status]
                = (int) $record->total;
        }

        $weeklyLabels = [];
        $weeklyPresent = [];
        $weeklyAbsent = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $day = $date->toDateString();

            $weeklyLabels[] = $date->format('D');

            $weeklyPresent[] = $weeklyCounts[$day]['Present'] ?? 0;
            $weeklyAbsent[] = $weeklyCounts[$day]['Absent'] ?? 0;
        }

        return view('dashboard', compact(
            'totalStudents',
            'presentToday',
            'absentToday',
            'attendanceRate',
            'recentAttendances',
            'weeklyLabels',
            'weeklyPresent',
            'weeklyAbsent'
        ));
    }
}
