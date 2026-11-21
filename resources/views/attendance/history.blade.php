@extends('layouts.app')

@section('title', 'StudentTrack | Attendance History')
@section('page-title', 'Attendance History')
@section('page-subtitle', 'Review and manage student attendance records.')

@push('styles')
<style>
    .welcome {
        background: linear-gradient(120deg, #6246a5, #a34d91);
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
    }

    .panel-header p {
        color: #929aaa;
        font-size: 12px;
        margin-top: 6px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
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
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #8062bd;
        box-shadow: 0 0 0 3px rgba(128, 98, 189, .1);
    }

    .filter-actions {
        display: flex;
        gap: 9px;
        margin-top: 20px;
    }

    .filter-btn {
        background: #6246a5;
        color: white;
        border: none;
        padding: 11px 17px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        transition: .2s;
    }

    .filter-btn:hover {
        background: #50358f;
    }

    .reset-btn {
        display: inline-block;
        background: #eeeafa;
        color: #6246a5;
        padding: 11px 17px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
    }

    .reset-btn:hover {
        background: #6246a5;
        color: white;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }

    .history-table th,
    .history-table td {
        padding: 15px 12px;
        border-bottom: 1px solid #edf0f5;
        text-align: left;
        font-size: 13px;
    }

    .history-table th {
        background: #f8f7fb;
        color: #858b9a;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .history-table td {
        color: #555e70;
    }

    .history-table tbody tr:hover {
        background: #faf9fd;
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

    .edit-btn {
        display: inline-block;
        background: #eeeafa;
        color: #6246a5;
        padding: 7px 13px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
        font-weight: bold;
    }

    .edit-btn:hover {
        background: #6246a5;
        color: white;
    }

    .delete-btn {
        background: #fff0f0;
        color: #d35454;
        padding: 7px 13px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
    }

    .delete-btn:hover {
        background: #d35454;
        color: white;
    }

    .action-links {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .action-links form {
        margin: 0;
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

    .pagination-info {
        color: #929aaa;
        font-size: 12px;
        margin-top: 20px;
    }

    .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 13px;
    }

    .pagination a,
    .pagination span {
        display: inline-block;
        padding: 9px 13px;
        border: 1px solid #e5e7ef;
        border-radius: 7px;
        text-decoration: none;
        color: #6246a5;
        font-size: 12px;
    }

    .pagination a:hover {
        background: #f2effa;
    }

    .pagination .current {
        background: linear-gradient(135deg, #6246a5, #9b59b6);
        color: white;
        border-color: transparent;
    }

    .pagination .disabled {
        color: #a0a5b5;
        background: #f8f7fb;
    }

    @media (max-width: 900px) {
        .filter-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 650px) {
        .panel {
            padding: 18px;
        }

        .panel-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            flex-wrap: wrap;
        }
    }
</style>
@endpush

@section('content')

    <section class="welcome">
        <h1>Attendance Records</h1>
        <p>Review and manage the attendance history of your students.</p>
    </section>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <section class="panel">
        <div class="panel-header">
            <div>
                <h3>Filter Attendance</h3>
                <p>Find records by date or student.</p>
            </div>
        </div>

        <form action="{{ route('attendance.history') }}" method="GET">
            <div class="filter-grid">

                <div class="form-group">
                    <label>From Date</label>
                    <input
                        type="date"
                        name="from_date"
                        value="{{ request('from_date') }}"
                    >
                </div>

                <div class="form-group">
                    <label>To Date</label>
                    <input
                        type="date"
                        name="to_date"
                        value="{{ request('to_date') }}"
                    >
                </div>

                <div class="form-group">
                    <label>Student</label>
                    <select name="student_id">
                        <option value="">All Students</option>

                        @foreach($students as $student)
                            <option
                                value="{{ $student->id }}"
                                {{ request('student_id') == $student->id ? 'selected' : '' }}
                            >
                                {{ $student->student_number }} -
                                {{ $student->first_name }} {{ $student->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="filter-actions">
                <button type="submit" class="filter-btn">
                    Apply Filters
                </button>

                <a href="{{ route('attendance.history') }}" class="reset-btn">
                    Reset
                </a>
            </div>
        </form>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div>
                <h3>Attendance History List</h3>
                <p>View, edit, or delete attendance records.</p>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Student Number</th>
                        <th>Student Name</th>
                        <th>Attendance Date</th>
                        <th>Status</th>
                        <th>Action</th>
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

                            <td>
                                <div class="action-links">
                                    <a
                                        href="{{ route('attendance.edit', $attendance->id) }}"
                                        class="edit-btn"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('attendance.destroy', $attendance->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this attendance record?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="delete-btn">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                No attendance records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($attendances->hasPages())
            <div class="pagination-info">
                Showing {{ $attendances->firstItem() }}
                to {{ $attendances->lastItem() }}
                of {{ $attendances->total() }} records
            </div>

            <div class="pagination">
                @if($attendances->onFirstPage())
                    <span class="disabled">Previous</span>
                @else
                    <a href="{{ $attendances->previousPageUrl() }}">Previous</a>
                @endif

                @foreach($attendances->getUrlRange(1, $attendances->lastPage()) as $page => $url)
                    @if($page == $attendances->currentPage())
                        <span class="current">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($attendances->hasMorePages())
                    <a href="{{ $attendances->nextPageUrl() }}">Next</a>
                @else
                    <span class="disabled">Next</span>
                @endif
            </div>
        @endif
    </section>

@endsection
