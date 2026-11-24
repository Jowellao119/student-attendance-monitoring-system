@extends('layouts.app')

@section('title', 'StudentTrack | Attendance')
@section('page-title', 'Attendance Management')
@section('page-subtitle', 'Record and monitor daily student attendance.')

@push('styles')
<style>
    .welcome {
        background: linear-gradient(120deg, #172554, #1d4ed8, #0891b2);
        color: white;
        padding: 27px 30px;
        border-radius: 14px;
        margin-bottom: 25px;
    }

    .welcome h1 {
        font-size: 25px;
        margin-bottom: 9px;
    }

    .welcome p {
        font-size: 14px;
        opacity: .9;
    }

    .panel {
        background: white;
        padding: 25px;
        border-radius: 13px;
        box-shadow: 0 3px 12px rgba(30, 30, 60, .04);
        margin-bottom: 25px;
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 22px;
    }

    .panel-header h3 {
        font-size: 18px;
        color: #172554;
    }

    .panel-header p {
        color: #929aaa;
        font-size: 12px;
        margin-top: 6px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        color: #555e70;
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 9px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 11px 14px;
        border: 1px solid #e5e7ef;
        border-radius: 8px;
        outline: none;
        font-size: 13px;
        color: #555e70;
        background: white;
        transition: .2s;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
    }

    .save-btn {
        display: inline-block;
        margin-top: 22px;
        background: linear-gradient(120deg, #2563eb, #0891b2);
        color: white;
        border: none;
        padding: 11px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        transition: .2s;
    }

    .save-btn:hover {
        background: linear-gradient(120deg, #1d4ed8, #0e7490);
        transform: translateY(-1px);
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .attendance-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .attendance-table th,
    .attendance-table td {
        padding: 15px 12px;
        border-bottom: 1px solid #edf0f5;
        text-align: left;
        font-size: 13px;
    }

    .attendance-table th {
        background: #eff6ff;
        color: #1e40af;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .attendance-table td {
        color: #555e70;
    }

    .attendance-table tbody tr:hover {
        background: #f0f9ff;
    }

    .status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
    }

    .present {
        background: #e8f8ef;
        color: #16834a;
    }

    .absent {
        background: #fff0f0;
        color: #d35454;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .empty {
        text-align: center !important;
        color: #929aaa !important;
        padding: 35px !important;
    }

    .success {
        background: #e8f8ef;
        color: #16834a;
        padding: 13px 15px;
        border-radius: 8px;
        margin-bottom: 18px;
        font-size: 13px;
    }

    .error-box {
        background: #fff0f0;
        color: #c03954;
        padding: 13px 15px;
        border-radius: 8px;
        margin-bottom: 18px;
        font-size: 13px;
    }

    .error-box ul {
        margin: 8px 0 0 20px;
    }

    @media (max-width: 650px) {
        .panel {
            padding: 18px;
        }

        .panel-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

        .welcome {
            padding: 22px;
        }
    }
</style>
@endpush

@section('content')

    <section class="welcome">
        <h1>Manage Attendance</h1>
        <p>Record and monitor the daily attendance of your students.</p>
    </section>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error-box">
            <strong>Please check the following:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="panel">
        <div class="panel-header">
            <div>
                <h3>Record Student Attendance</h3>
                <p>Select a student and enter the attendance details.</p>
            </div>
        </div>

        <form action="{{ route('attendance.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group full">
                    <label>Select Student</label>
                    <select name="student_id" required>
                        <option value="">Choose a student</option>

                        @foreach($students as $student)
                            <option value="{{ $student->id }}"
                                {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->student_number }} -
                                {{ $student->first_name }} {{ $student->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Attendance Date</label>
                    <input
                        type="date"
                        name="attendance_date"
                        value="{{ old('attendance_date', date('Y-m-d')) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Attendance Status</label>
                    <select name="status" required>
                        <option value="">Select status</option>
                        <option value="Present" {{ old('status') == 'Present' ? 'selected' : '' }}>
                            Present
                        </option>
                        <option value="Absent" {{ old('status') == 'Absent' ? 'selected' : '' }}>
                            Absent
                        </option>
                    </select>
                </div>
            </div>

            <button type="submit" class="save-btn">
                + Save Attendance
            </button>
        </form>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div>
                <h3>Attendance Records</h3>
                <p>View the latest recorded student attendance.</p>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Student Number</th>
                        <th>Student Name</th>
                        <th>Attendance Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->student->student_number }}</td>

                            <td>
                                {{ $attendance->student->first_name }}
                                {{ $attendance->student->last_name }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('M d, Y') }}
                            </td>

                            <td>
                                @if($attendance->status == 'Present')
                                    <span class="status present">
                                        <span class="status-dot"></span>
                                        Present
                                    </span>
                                @else
                                    <span class="status absent">
                                        <span class="status-dot"></span>
                                        Absent
                                    </span>
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
