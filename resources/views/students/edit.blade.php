<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - StudentTrack</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f3f6fb;
            color: #1e293b;
            min-height: 100vh;
            padding: 45px 20px;
        }

        .container {
            max-width: 780px;
            margin: auto;
        }

        /* HEADER */
        .header {
            background: linear-gradient(120deg, #172554, #1d4ed8, #0891b2);
            color: white;
            padding: 32px 35px;
            border-radius: 16px 16px 0 0;
        }

        .back-link {
            display: inline-block;
            color: #dbeafe;
            text-decoration: none;
            font-size: 13px;
            margin-bottom: 22px;
            transition: .2s;
        }

        .back-link:hover {
            color: white;
            text-decoration: underline;
        }

        .header h1 {
            font-size: 27px;
            margin-bottom: 9px;
        }

        .header p {
            font-size: 14px;
            color: #e0f2fe;
            line-height: 1.6;
        }

        /* FORM CARD */
        .form-card {
            background: white;
            padding: 32px 35px;
            border-radius: 0 0 16px 16px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, .06);
        }

        .section-heading {
            margin-bottom: 26px;
            padding-bottom: 18px;
            border-bottom: 1px solid #e8edf5;
        }

        .section-heading h2 {
            font-size: 19px;
            margin-bottom: 7px;
            color: #172554;
        }

        .section-heading p {
            font-size: 13px;
            color: #64748b;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 22px;
            row-gap: 5px;
        }

        .form-group {
            margin-bottom: 21px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 9px;
            color: #334155;
        }

        .required {
            color: #dc2626;
        }

        input, select {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #dbe3ee;
            border-radius: 9px;
            font-size: 14px;
            outline: none;
            background: white;
            color: #1e293b;
            transition: .2s;
        }

        input:focus, select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        input::placeholder {
            color: #94a3b8;
        }

        select {
            cursor: pointer;
        }

        /* VALIDATION ERRORS */
        .error-box {
            background: #fef2f2;
            color: #b91c1c;
            padding: 15px 18px;
            border-radius: 9px;
            margin-bottom: 25px;
            font-size: 13px;
            border-left: 4px solid #ef4444;
        }

        .error-box strong {
            display: block;
            margin-bottom: 8px;
        }

        .error-box ul {
            padding-left: 20px;
            line-height: 1.7;
        }

        /* BUTTONS */
        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 15px;
            padding-top: 23px;
            border-top: 1px solid #e8edf5;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 9px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            transition: .2s;
        }

        .cancel-btn {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .cancel-btn:hover {
            background: #dbeafe;
        }

        .update-btn {
            background: linear-gradient(135deg, #2563eb, #0891b2);
            color: white;
        }

        .update-btn:hover {
            background: linear-gradient(135deg, #1d4ed8, #0e7490);
            box-shadow: 0 5px 12px rgba(37, 99, 235, .2);
            transform: translateY(-1px);
        }

        .footer {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            margin-top: 25px;
        }

        /* RESPONSIVE */
        @media (max-width: 600px) {
            body {
                padding: 20px 12px;
            }

            .header {
                padding: 25px 22px;
            }

            .header h1 {
                font-size: 23px;
            }

            .form-card {
                padding: 25px 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .actions {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <a href="{{ route('students.index') }}" class="back-link">
            ← Back to Students
        </a>

        <h1>Edit Student</h1>
        <p>Update the student information below.</p>
    </div>

    <div class="form-card">

        @if ($errors->any())
            <div class="error-box">
                <strong>Please check the following information:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="section-heading">
            <h2>Student Information</h2>
            <p>Review and update the student's details.</p>
        </div>

        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label for="student_number">
                        Student Number <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="student_number"
                        name="student_number"
                        value="{{ old('student_number', $student->student_number) }}"
                        placeholder="e.g. 2026-0002"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="first_name">
                        First Name <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="{{ old('first_name', $student->first_name) }}"
                        placeholder="Enter first name"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="last_name">
                        Last Name <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="{{ old('last_name', $student->last_name) }}"
                        placeholder="Enter last name"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="course">
                        Course <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="course"
                        name="course"
                        value="{{ old('course', $student->course) }}"
                        placeholder="e.g. BSIT"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="year_level">
                        Year Level <span class="required">*</span>
                    </label>

                    <select id="year_level" name="year_level" required>
                        <option value="">Select Year Level</option>

                        <option value="1st Year" {{ old('year_level', $student->year_level) == '1st Year' ? 'selected' : '' }}>
                            1st Year
                        </option>

                        <option value="2nd Year" {{ old('year_level', $student->year_level) == '2nd Year' ? 'selected' : '' }}>
                            2nd Year
                        </option>

                        <option value="3rd Year" {{ old('year_level', $student->year_level) == '3rd Year' ? 'selected' : '' }}>
                            3rd Year
                        </option>

                        <option value="4th Year" {{ old('year_level', $student->year_level) == '4th Year' ? 'selected' : '' }}>
                            4th Year
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="section">
                        Section <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="section"
                        name="section"
                        value="{{ old('section', $student->section) }}"
                        placeholder="e.g. 2A"
                        required
                    >
                </div>

            </div>

            <div class="actions">
                <a href="{{ route('students.index') }}" class="btn cancel-btn">
                    Cancel
                </a>

                <button type="submit" class="btn update-btn">
                    Update Student
                </button>
            </div>

        </form>

    </div>

    <div class="footer">
        © {{ date('Y') }} StudentTrack. All rights reserved.
    </div>

</div>

</body>
</html>
