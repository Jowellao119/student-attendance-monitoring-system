@extends('layouts.app')

@section('title', 'Reports - StudentTrack')
@section('page-title', 'Attendance Reports')
@section('page-subtitle', 'View and monitor student attendance summaries')

@push('styles')
<style>
    .welcome {
        background: linear-gradient(120deg, #172554, #1d4ed8, #0891b2);
        color: white;
        padding: 27px 30px;
        border-radius: 14px;
        margin-bottom: 25px;
        box-shadow: 0 8px 20px rgba(29, 78, 216, .12);
    }

    .welcome h1 {
        font-size: 25px;
        margin-bottom: 9px;
        font-weight: 700;
    }

    .welcome p {
        font-size: 14px;
        opacity: .9;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 25px;
    }

    .card {
        background: white;
        padding: 22px;
        border-radius: 12px;
        border-top: 4px solid #2563eb;
        box-shadow: 0 3px 12px rgba(30, 30, 60, .04);
        transition: transform .2s, box-shadow .2s;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 18px rgba(30, 30, 60, .08);
    }

    .card:nth-child(2) { border-top-color: #219653; }
    .card:nth-child(3) { border-top-color: #d35454; }
    .card:nth-child(4) { border-top-color: #0891b2; }

    .card p {
        color: #858b9a;
        font-size: 13px;
        margin-bottom: 12px;
    }

    .card h2 {
        font-size: 27px;
        color: #2563eb;
        font-weight: 700;
    }

    .present-color { color: #219653 !important; }
    .absent-color { color: #c0392b !important; }
    .rate-color { color: #0891b2 !important; }

    .section {
        background: white;
        padding: 25px;
        border-radius: 13px;
        margin-bottom: 25px;
        box-shadow: 0 3px 12px rgba(30, 30, 60, .04);
    }

    .section h3 {
        font-size: 18px;
        margin-bottom: 20px;
        color: #172554;
        font-weight: 700;
    }

    .filter-form {
        display: flex;
        gap: 15px;
        align-items: end;
        flex-wrap: wrap;
    }

    .form-group {
        flex: 1;
        min-width: 180px;
    }

    .filter-form label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 9px;
        color: #555e70;
    }

    .filter-form input {
        width: 100%;
        padding: 12px;
        border: 1px solid #e5e7ef;
        border-radius: 8px;
        outline: none;
        font-size: 13px;
        transition: .2s;
    }

    .filter-form input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
    }

    .filter-form button {
        padding: 12px 18px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        color: white;
        background: linear-gradient(120deg, #2563eb, #0891b2);
        font-size: 13px;
        transition: .2s;
    }

    .filter-form button:hover {
        background: linear-gradient(120deg, #1d4ed8, #0e7490);
        transform: translateY(-1px);
    }

    .reset-btn {
        padding: 12px 18px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: .2s;
    }

    .reset-btn:hover {
        background: #dbeafe;
    }

    .print-btn {
        background: #334155 !important;
    }

    .print-btn:hover {
        background: #1e293b !important;
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 550px;
    }

    .report-table th,
    .report-table td {
        padding: 15px 12px;
        text-align: left;
        border-bottom: 1px solid #edf0f5;
        font-size: 13px;
    }

    .report-table th {
        color: #334155;
        font-size: 11px;
        background: #eff6ff;
        text-transform: uppercase;
        letter-spacing: .4px;
        font-weight: 700;
    }

    .report-table td {
        color: #555e70;
    }

    .report-table tbody tr {
        transition: background .2s;
    }

    .report-table tbody tr:hover {
        background: #f0f9ff;
    }

    .present,
    .absent {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .present {
        background: #e5f8ed;
        color: #219653;
    }

    .absent {
        background: #fdeaea;
        color: #c0392b;
    }

    .present::before,
    .absent::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }

    .present::before {
        background: #219653;
    }

    .absent::before {
        background: #c0392b;
    }

    .empty {
        text-align: center;
        color: #929aaa !important;
        padding: 30px !important;
    }

    @media (max-width: 1100px) {
        .cards {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 650px) {
        .cards {
            grid-template-columns: 1fr;
        }

        .section {
            padding: 18px;
        }

        .filter-form {
            flex-direction: column;
            align-items: stretch;
        }

        .form-group {
            width: 100%;
        }

        .filter-form button,
        .reset-btn {
            text-align: center;
        }
    }

    @media print {
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        body {
            background: white !important;
            color: black !important;
        }

        .sidebar,
        .filter-section,
        .no-print {
            display: none !important;
        }

        .main {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        .topbar {
            margin-bottom: 15px;
        }

        .welcome {
            background: #eee !important;
            color: black !important;
            box-shadow: none;
            border: 1px solid #ccc;
            margin-bottom: 15px;
        }

        .cards {
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }

        .card,
        .section {
            box-shadow: none;
            border: 1px solid #ddd;
            break-inside: avoid;
        }

        .section {
            padding: 15px;
        }

        .report-table {
            min-width: 0;
            width: 100%;
        }

        .report-table th,
        .report-table td {
            padding: 9px;
            font-size: 11px;
        }

        .report-table th {
            background: #eee !important;
            color: black !important;
        }

        .present,
        .absent {
            background: transparent !important;
            color: black !important;
            padding: 0;
        }

        .present::before,
        .absent::before {
            background: #555 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .table-wrap {
            overflow: visible;
        }

        .report-table tr {
            break-inside: avoid;
        }
    }
</style>
@endpush

@section('content')

<section class="welcome">
    <h1>Attendance Summary</h1>
    <p>Monitor attendance performance using recorded student data.</p>
</section>

<section class="section filter-section">
    <h3>Filter Report by Date</h3>

    <form action="{{ route('reports.index') }}" method="GET" class="filter-form">

        <div class="form-group">
            <label for="from_date">From Date</label>
            <input
                type="date"
                id="from_date"
                name="from_date"
                value="{{ $fromDate }}"
            >
        </div>

        <div class="form-group">
            <label for="to_date">To Date</label>
            <input
                type="date"
                id="to_date"
                name="to_date"
                value="{{ $toDate }}"
            >
        </div>

        <button type="submit">Generate Report</button>

        <a href="{{ route('reports.index') }}" class="reset-btn">Reset</a>

        <button
            type="button"
            class="print-btn no-print"
            onclick="window.print()"
        >
            Print / Export PDF
        </button>

    </form>
</section>

<section class="cards">

    <div class="card">
        <p>Total Records</p>
        <h2>{{ $totalRecords }}</h2>
    </div>

    <div class="card">
        <p>Present</p>
        <h2 class="present-color">{{ $presentCount }}</h2>
    </div>

    <div class="card">
        <p>Absent</p>
        <h2 class="absent-color">{{ $absentCount }}</h2>
    </div>

    <div class="card">
        <p>Attendance Rate</p>
        <h2 class="rate-color">{{ $attendanceRate }}%</h2>
    </div>

</section>

<section class="section">
    <h3>Detailed Attendance Report</h3>

    <div class="table-wrap">
        <table class="report-table">
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Student Name</th>
                    <th>Attendance Date</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reportAttendances as $attendance)
                    <tr>
                        <td>
                            {{ $attendance->student->student_number ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $attendance->student->first_name ?? '' }}
                            {{ $attendance->student->last_name ?? '' }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('M d, Y') }}
                        </td>

                        <td>
                            @if($attendance->status == 'Present')
                                <span class="present">Present</span>
                            @else
                                <span class="absent">Absent</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty">
                            No attendance records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection
