@extends('layouts.app')

@section('title', 'StudentTrack | Students')
@section('page-title', 'Student Management')
@section('page-subtitle', 'Manage and organize your registered students.')

@push('styles')
<style>
    /* WELCOME BANNER */
    .welcome {
        position: relative;
        overflow: hidden;
        background: linear-gradient(120deg, #172554, #1d4ed8, #0891b2);
        color: white;
        padding: 30px;
        border-radius: 18px;
        margin-bottom: 25px;
        box-shadow: 0 10px 25px rgba(29, 78, 216, .15);
    }

    .welcome::after {
        content: "🎓";
        position: absolute;
        right: 35px;
        bottom: -30px;
        font-size: 115px;
        opacity: .10;
        pointer-events: none;
    }

    .welcome h2 {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 9px;
    }

    .welcome p {
        font-size: 13px;
        opacity: .9;
    }

    /* SUMMARY CARDS */
    .summary {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 25px;
    }

    .summary-card {
        position: relative;
        background: white;
        padding: 22px 24px;
        border-radius: 15px;
        border: 1px solid #edf0f5;
        border-left: 5px solid #2563eb;
        box-shadow: 0 4px 15px rgba(30, 30, 60, .035);
        transition: .25s;
    }

    .summary-card:nth-child(2) {
        border-left-color: #0891b2;
    }

    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 22px rgba(30, 30, 60, .08);
    }

    .summary-card p {
        color: #858b9a;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .summary-card h2 {
        font-size: 30px;
        font-weight: 800;
        color: #1d4ed8;
    }

    .summary-card:nth-child(2) h2 {
        color: #0891b2;
    }

    .summary-card h2 span {
        font-size: 13px;
        color: #929aaa;
        font-weight: 500;
    }

    /* MAIN PANEL */
    .panel {
        background: white;
        padding: 25px;
        border-radius: 17px;
        border: 1px solid #edf0f5;
        box-shadow: 0 4px 15px rgba(30, 30, 60, .035);
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 22px;
    }

    .panel-header h3 {
        font-size: 17px;
        font-weight: 800;
        color: #30364a;
    }

    .panel-header p {
        color: #929aaa;
        font-size: 12px;
        margin-top: 6px;
    }

    /* ADD BUTTON */
    .add-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        background: linear-gradient(110deg, #2563eb, #0891b2);
        color: white;
        text-decoration: none;
        padding: 12px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
        transition: .25s;
        box-shadow: 0 4px 12px rgba(37, 99, 235, .18);
    }

    .add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 16px rgba(37, 99, 235, .25);
        color: white;
    }

    /* SEARCH */
    .search-box {
        width: 100%;
        max-width: 370px;
        padding: 12px 15px;
        border: 1px solid #e2e5ec;
        border-radius: 10px;
        outline: none;
        font-size: 13px;
        margin-bottom: 20px;
        transition: .2s;
    }

    .search-box:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    /* TABLE */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .student-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }

    .student-table th,
    .student-table td {
        padding: 15px 12px;
        border-bottom: 1px solid #edf0f5;
        text-align: left;
        font-size: 13px;
    }

    .student-table th {
        background: #eff6ff;
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .student-table td {
        color: #555e70;
    }

    .student-table tbody tr {
        transition: background .2s;
    }

    .student-table tbody tr:hover {
        background: #f0f9ff;
    }

    /* STUDENT INFORMATION */
    .student-info {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 160px;
    }

    .avatar {
        width: 37px;
        height: 37px;
        border-radius: 12px;
        background: linear-gradient(135deg, #dbeafe, #cffafe);
        color: #1d4ed8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .student-name {
        color: #303649;
        font-weight: 700;
    }

    .course-badge {
        display: inline-block;
        background: #dbeafe;
        color: #1d4ed8;
        padding: 6px 10px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 800;
    }

    /* EDIT BUTTON */
    .edit-btn {
        display: inline-block;
        background: #dbeafe;
        color: #1d4ed8;
        padding: 8px 14px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 800;
        transition: .2s;
    }

    .edit-btn:hover {
        background: #2563eb;
        color: white;
        transform: translateY(-1px);
    }

    /* MESSAGES */
    .empty {
        text-align: center;
        color: #929aaa;
        padding: 35px !important;
        font-size: 13px;
    }

    .success {
        background: #dcfce7;
        color: #15803d;
        padding: 13px 16px;
        border-radius: 9px;
        margin-bottom: 18px;
        font-size: 13px;
        border: 1px solid #bbf7d0;
    }

    /* RESPONSIVE */
    @media (max-width: 650px) {
        .summary {
            grid-template-columns: 1fr;
        }

        .panel {
            padding: 18px;
        }

        .panel-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .welcome {
            padding: 24px;
        }

        .welcome::after {
            right: 10px;
            font-size: 85px;
        }

        .add-btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

    <!-- WELCOME BANNER -->
    <section class="welcome">
        <h2>Manage Your Students 👨‍🎓</h2>
        <p>View, organize, and manage student information in one place.</p>
    </section>

    <!-- SUMMARY CARDS -->
    <section class="summary">
        <div class="summary-card">
            <p>Total Registered Students</p>
            <h2>{{ $students->count() }}</h2>
        </div>

        <div class="summary-card">
            <p>Student Records</p>
            <h2>
                {{ $students->count() }}
                <span>records</span>
            </h2>
        </div>
    </section>

    <!-- STUDENT LIST -->
    <section class="panel">

        @if (session('success'))
            <div class="success">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div class="panel-header">
            <div>
                <h3>Student List</h3>
                <p>Manage and view all registered students.</p>
            </div>

            <a href="{{ route('students.create') }}" class="add-btn">
                + Add Student
            </a>
        </div>

        <!-- SEARCH -->
        <input
            type="text"
            id="studentSearch"
            class="search-box"
            placeholder="🔍 Search student number, name, course..."
            oninput="searchStudents()"
        >

        <!-- TABLE -->
        <div class="table-wrapper">
            <table class="student-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Student Number</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>Section</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="studentTable">
                    @forelse ($students as $student)
                        <tr>
                            <td>
                                <div class="student-info">
                                    <div class="avatar">
                                        {{ strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)) }}
                                    </div>

                                    <div class="student-name">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </div>
                                </div>
                            </td>

                            <td>{{ $student->student_number }}</td>

                            <td>
                                <span class="course-badge">
                                    {{ $student->course }}
                                </span>
                            </td>

                            <td>{{ $student->year_level }}</td>
                            <td>{{ $student->section }}</td>

                            <td>
                                <a href="{{ route('students.edit', $student->id) }}" class="edit-btn">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                No student records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <p id="noResults" class="empty" style="display:none;">
            No matching students found.
        </p>

    </section>

@endsection

@push('scripts')
<script>
    function searchStudents() {
        const input = document.getElementById('studentSearch');
        const filter = input.value.toLowerCase().trim();
        const rows = document.querySelectorAll('#studentTable tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const isEmptyRow = row.querySelector('.empty');

            if (isEmptyRow) {
                row.style.display = filter === '' ? '' : 'none';
                return;
            }

            const text = row.textContent.toLowerCase();
            const matches = text.includes(filter);

            row.style.display = matches ? '' : 'none';

            if (matches) {
                visibleCount++;
            }
        });

        const noResults = document.getElementById('noResults');
        noResults.style.display =
            filter !== '' && visibleCount === 0 ? 'block' : 'none';
    }
</script>
@endpush
