<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $query = Attendance::with('student');

        if ($fromDate) {
            $query->whereDate('attendance_date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('attendance_date', '<=', $toDate);
        }

        $reportAttendances = $query
            ->latest('attendance_date')
            ->get();

        $totalRecords = $reportAttendances->count();

        $presentCount = $reportAttendances
            ->where('status', 'Present')
            ->count();

        $absentCount = $reportAttendances
            ->where('status', 'Absent')
            ->count();

        $attendanceRate = $totalRecords > 0
            ? round(($presentCount / $totalRecords) * 100, 1)
            : 0;

        return view('reports', compact(
            'fromDate',
            'toDate',
            'reportAttendances',
            'totalRecords',
            'presentCount',
            'absentCount',
            'attendanceRate'
        ));
    }
}
