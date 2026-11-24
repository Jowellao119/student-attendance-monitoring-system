@extends('layouts.app')

@section('title', 'StudentTrack | Edit Attendance')
@section('page-title', 'Edit Attendance')
@section('page-subtitle', 'Update the student attendance information.')

@push('styles')
<style>
    .edit-container {
        max-width: 760px;
        margin: 0 auto;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 18px;
        color: #2563eb;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
    }

    .back-link:hover {
        color: #0891b2;
    }

    .edit-card {
        background: white;
        border-radius: 14px;
        padding: 30px;
        box-shadow: 0 3px 12px rgba(30, 30, 60, .04);
    }

    .edit-header {
        border-bottom: 1px solid #edf0f5;
        padding-bottom: 20px;
        margin-bottom: 25px;
    }

    .edit-header h2 {
        font-size: 22px;
        color: #172554;
        margin-bottom: 7px;
    }

    .edit-header p {
        color: #929aaa;
        font-size: 13px;
    }

    .section-title {
        font-size: 14px;
        font-weight: bold;
        color: #1d4ed8;
        margin-bottom: 17px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 9px;
        font-size: 13px;
        font-weight: bold;
        color: #555e70;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #e5e7ef;
        border-radius: 8px;
        font-size: 13px;
        background: white;
        color: #555e70;
        outline: none;
        transition: .2s;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
    }

    .student-box {
        background: #eff6ff;
        border: 1px solid #dbeafe;
        border-radius: 9px;
        padding: 16px;
        margin-bottom: 25px;
    }

    .student-box p {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .student-box strong {
        color: #1d4ed8;
        font-size: 15px;
    }

    .error-box {
        background: #fff0f0;
        color: #c03954;
        padding: 13px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 13px;
    }

    .error {
        color: #c03954;
        font-size: 12px;
        margin-top: 6px;
    }

    .status-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .status-option {
        position: relative;
    }

    .status-option input {
        position: absolute;
        opacity: 0;
        width: 1px;
        height: 1px;
    }

    .status-option label {
        border: 1px solid #e5e7ef;
        border-radius: 9px;
        padding: 14px;
        text-align: center;
        cursor: pointer;
        margin: 0;
        transition: .2s;
    }

    .status-option.present label {
        color: #16834a;
    }

    .status-option.absent label {
        color: #d35454;
    }

    .status-option.present input:checked + label {
        background: #e8f8ef;
        border-color: #27ae60;
    }

    .status-option.absent input:checked + label {
        background: #fff0f0;
        border-color: #d35454;
    }

    .status-option input:focus-visible + label {
        outline: 3px solid rgba(37, 99, 235, .2);
    }

    .buttons {
        display: flex;
        gap: 12px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #edf0f5;
    }

    .btn {
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        cursor: pointer;
        font-size: 13px;
        font-weight: bold;
        text-align: center;
        transition: .2s;
    }

    .save-btn {
        flex: 1;
        color: white;
        background: linear-gradient(120deg, #2563eb, #0891b2);
    }

    .save-btn:hover {
        background: linear-gradient(120deg, #1d4ed8, #0e7490);
        transform: translateY(-1px);
    }

    .cancel-btn {
        background: #f1f5f9;
        color: #475569;
    }

    .cancel-btn:hover {
        background: #e2e8f0;
    }

    @media (max-width: 600px) {
        .edit-card {
            padding: 22px 18px;
        }

        .buttons {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')

<div class="edit-container">

    <a href="{{ route('attendance.history') }}" class="back-link">
        ← Back to Attendance History
    </a>

    <div class="edit-card">

        <div class="edit-header">
            <h2>Edit Attendance</h2>
            <p>Update the student's attendance information below.</p>
        </div>

        @if ($errors->any())
            <div class="error-box">
                <strong>Please check the following information:</strong>
                <ul style="margin: 8px 0 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="section-title">Student Information</div>

            <div class="form-group">
                <label for="student_id">Select Student</label>

                <select name="student_id" id="student_id" required>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}"
                            {{ old('student_id', $attendance->student_id) == $student->id ? 'selected' : '' }}>
                            {{ $student->student_number }} -
                            {{ $student->first_name }} {{ $student->last_name }}
                        </option>
                    @endforeach
                </select>

                @error('student_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="student-box">
                <p>Currently editing attendance record</p>
                <strong>
                    {{ $attendance->student->first_name }}
                    {{ $attendance->student->last_name }}
                </strong>
            </div>

            <div class="section-title">Attendance Details</div>

            <div class="form-group">
                <label for="attendance_date">Attendance Date</label>

                <input
                    type="date"
                    id="attendance_date"
                    name="attendance_date"
                    value="{{ old('attendance_date', \Carbon\Carbon::parse($attendance->attendance_date)->format('Y-m-d')) }}"
                    required
                >

                @error('attendance_date')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Attendance Status</label>

                <div class="status-options">
                    <div class="status-option present">
                        <input
                            type="radio"
                            id="present"
                            name="status"
                            value="Present"
                            {{ old('status', $attendance->status) == 'Present' ? 'checked' : '' }}
                            required
                        >
                        <label for="present">✓ Present</label>
                    </div>

                    <div class="status-option absent">
                        <input
                            type="radio"
                            id="absent"
                            name="status"
                            value="Absent"
                            {{ old('status', $attendance->status) == 'Absent' ? 'checked' : '' }}
                            required
                        >
                        <label for="absent">✕ Absent</label>
                    </div>
                </div>

                @error('status')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="buttons">
                <a href="{{ route('attendance.history') }}" class="btn cancel-btn">
                    Cancel
                </a>

                <button type="submit" class="btn save-btn">
                    Save Changes
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
