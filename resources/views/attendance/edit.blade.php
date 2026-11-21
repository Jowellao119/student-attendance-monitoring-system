<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Attendance - StudentTrack</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f6fa;
            min-height: 100vh;
            padding: 40px 20px;
            color: #333;
        }

        .container {
            max-width: 680px;
            margin: 20px auto;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #8e44ad;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .back-link:hover {
            color: #c0392b;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 32px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.06);
        }

        .header {
            border-bottom: 1px solid #eee;
            padding-bottom: 22px;
            margin-bottom: 25px;
        }

        .header h2 {
            font-size: 25px;
            margin-bottom: 8px;
            color: #333;
        }

        .header p {
            color: #888;
            font-size: 14px;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            color: #8e44ad;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 9px;
            font-size: 14px;
            font-weight: bold;
            color: #444;
        }

        input, select {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background: #fff;
            color: #333;
            outline: none;
            transition: 0.2s;
        }

        input:focus, select:focus {
            border-color: #8e44ad;
            box-shadow: 0 0 0 3px rgba(142,68,173,0.10);
        }

        .student-box {
            background: #faf7fc;
            border: 1px solid #eadcf0;
            border-radius: 9px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .student-box p {
            font-size: 13px;
            color: #777;
            margin-bottom: 5px;
        }

        .student-box strong {
            color: #8e44ad;
            font-size: 15px;
        }

        .error-box {
            background: #fff1f0;
            border: 1px solid #f5c6cb;
            color: #c0392b;
            padding: 13px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .error {
            color: #c0392b;
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
            border: 1px solid #ddd;
            border-radius: 9px;
            padding: 14px;
            text-align: center;
            cursor: pointer;
            margin: 0;
            transition: 0.2s;
        }

        .status-option.present label {
            color: #219653;
        }

        .status-option.absent label {
            color: #c0392b;
        }

        .status-option.present input:checked + label {
            background: #eafaf1;
            border-color: #27ae60;
        }

        .status-option.absent input:checked + label {
            background: #fff0ef;
            border-color: #c0392b;
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            padding-top: 22px;
            border-top: 1px solid #eee;
        }

        .btn {
            padding: 13px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            transition: 0.2s;
        }

        .save-btn {
            flex: 1;
            color: white;
            background: linear-gradient(135deg, #8e44ad, #c0392b);
        }

        .save-btn:hover {
            opacity: 0.9;
        }

        .cancel-btn {
            background: #eee;
            color: #555;
        }

        .cancel-btn:hover {
            background: #ddd;
        }

        @media (max-width: 600px) {
            body {
                padding: 20px 12px;
            }

            .card {
                padding: 22px 18px;
            }

            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <a href="{{ route('attendance.history') }}" class="back-link">
        ← Back to Attendance History
    </a>

    <div class="card">

        <div class="header">
            <h2>Edit Attendance</h2>
            <p>Update the student's attendance information below.</p>
        </div>

        @if ($errors->any())
            <div class="error-box">
                Please check the information you entered.
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
                            {{ $student->student_number }} - {{ $student->first_name }} {{ $student->last_name }}
                        </option>
                    @endforeach
                </select>

                @error('student_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="student-box">
                <p>Currently editing attendance record</p>
                <strong>{{ $attendance->student->first_name }} {{ $attendance->student->last_name }}</strong>
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

</body>
</html>
