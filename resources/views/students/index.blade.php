
@extends('layouts.app')

@section('title', 'StudentTrack | Students')
@section('page-title', 'Student Management')
@section('page-subtitle', 'Manage and organize your registered students.')

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

    .summary {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 25px;
    }

    .summary-card {
        background: white;
        padding: 22px;
        border-radius: 12px;
        border-top: 4px solid #8062bd;
        box-shadow: 0 3px 12px rgba(30, 30, 60, .04);
        transition: .2s;
    }

    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 18px rgba(30, 30, 60, .08);
    }

    .summary-card p {
        color: #858b9a;
        font-size: 13px;
        margin-bottom: 10px;
    }

    .summary-card h2 {
        font-size: 28px;
        color: #6246a5;
    }

    .panel {
        background: white;
        padding: 25px;
        border-radius: 13px;
        box-shadow: 0 3px 12px rgba(30, 30, 60, .04);
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

    .add-btn {
        background: #6246a5;
        color: white;
        text-decoration: none;
        padding: 11px 17px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: bold;
        white-space: nowrap;
        transition: .2s;
    }

    .add-btn:hover {
        background: #50358f;
    }

    .search-box {
        width: 100%;
        max-width: 350px;
        padding: 11px 14px;
        border: 1px solid #e5e7ef;
        border-radius: 8px;
        outline: none;
        font-size: 13px;
        margin-bottom: 20px;
    }

    .search-box:focus {
        border-color: #8062bd;
        box-shadow: 0 0 0 3px rgba(128, 98, 189, .1);
    }

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
        background: #f8f7fb;
        color: #858b9a;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .student-table td {
        color: #555e70;
    }

    .student-table tbody tr:hover {
        background: #faf9fd;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 160px;
    }

    .avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #eee8fa;
        color: #6246a5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        flex-shrink: 0;
    }

    .student-name {
        color: #303649;
        font-weight: bold;
    }

    .course-badge {
        background: #f0edfa;
        color: #6246a5;
        padding: 6px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: bold;
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

    .empty {
        text-align: center;
        color: #929aaa;
        padding: 35px;
    }

    .success {
        background: #e8f8ef;
        color: #16834a;
        padding: 13px 15px;
        border-radius: 8px;
        margin-bottom: 18px;
        font-size: 13px;
    }

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
    }
</style>
@endpush

@section('content')

    <section class="welcome">
        <h1>Manage Your Students</h1>
        <p>View and organize student information in one place.</p>
    </section>

    <section class="summary">
        <div class="summary-card">
            <p>Total Registered Students</p>
            <h2>{{ $students->count() }}</h2>
        </div>

        <div class="summary-card">
            <p>Student Records</p>
            <h2>
                {{ $students->count() }}
                <span style="font-size:14px;color:#929aaa;">records</span>
            </h2>
        </div>
    </section>

    <section class="panel">

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
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

        <input
            type="text"
            id="studentSearch"
            class="search-box"
            placeholder="Search student number, name, course..."
            onkeyup="searchStudents()"
        >

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
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('#studentTable tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const matches = text.includes(filter);

            row.style.display = matches ? '' : 'none';

            if (matches && !row.querySelector('.empty')) {
                visibleCount++;
            }
        });

        const noResults = document.getElementById('noResults');
        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    }
</script>
@endpush
