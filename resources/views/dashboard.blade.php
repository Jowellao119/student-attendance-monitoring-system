
@extends('layouts.app')

@section('title', 'StudentTrack | Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', "Welcome back! Here's your attendance overview.")

@push('styles')
<style>
    .welcome {
        background: linear-gradient(120deg, #6246a5, #a34d91);
        color: white;
        padding: 30px;
        border-radius: 14px;
        margin-bottom: 26px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-shadow: 0 5px 15px rgba(98, 70, 165, .15);
    }

    .welcome h2 {
        margin-bottom: 10px;
        font-size: 23px;
    }

    .welcome p {
        font-size: 14px;
        opacity: .9;
        line-height: 1.6;
    }

    .welcome-date {
        margin-top: 12px;
        font-size: 12px !important;
    }

    .welcome-btn {
        background: white;
        color: #6246a5;
        text-decoration: none;
        padding: 13px 19px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: bold;
        white-space: nowrap;
        transition: .2s;
    }

    .welcome-btn:hover {
        background: #f1edfa;
        transform: translateY(-2px);
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 26px;
    }

    .card {
        background: white;
        padding: 21px;
        border-radius: 12px;
        border: 1px solid #edf0f5;
        border-top: 4px solid #6246a5;
        box-shadow: 0 3px 10px rgba(0,0,0,.02);
        transition: .2s;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 7px 18px rgba(0,0,0,.06);
    }

    .card.blue { border-top-color: #4388e8; }
    .card.green { border-top-color: #28a879; }
    .card.red { border-top-color: #dc6262; }
    .card.purple { border-top-color: #8b65cb; }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 17px;
    }

    .card-label {
        color: #7b8496;
        font-size: 13px;
        font-weight: bold;
    }

    .card h2 {
        font-size: 29px;
        margin-bottom: 7px;
    }

    .card-subtext {
        font-size: 11px;
        color: #a0a6b5;
    }

    .icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
    }

    .icon svg {
        width: 21px;
        height: 21px;
        stroke: currentColor;
        fill: none;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .blue .icon {
        background: #e8f1ff;
        color: #4388e8;
    }

    .green .icon {
        background: #e0f7ec;
        color: #28a879;
    }

    .red .icon {
        background: #fde8e8;
        color: #dc6262;
    }

    .purple .icon {
        background: #f0eafb;
        color: #8b65cb;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .section {
        background: white;
        padding: 24px;
        border-radius: 12px;
        border: 1px solid #edf0f5;
        box-shadow: 0 3px 10px rgba(0,0,0,.02);
        min-width: 0;
        margin-bottom: 25px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
        gap: 12px;
    }

    .section h3 {
        font-size: 16px;
    }

    .section-description {
        color: #a0a6b5;
        font-size: 12px;
        margin-top: 5px;
    }

    .chart-container {
        position: relative;
        height: 260px;
        width: 100%;
    }

    .view-all {
        color: #6246a5;
        text-decoration: none;
        font-size: 12px;
        font-weight: bold;
        white-space: nowrap;
    }

    .view-all:hover {
        text-decoration: underline;
    }

    .table-tools {
        margin-bottom: 17px;
    }

    .search-input {
        width: 100%;
        max-width: 320px;
        padding: 11px 14px;
        border: 1px solid #e2e5ec;
        border-radius: 8px;
        outline: none;
        font-size: 13px;
    }

    .search-input:focus {
        border-color: #6246a5;
        box-shadow: 0 0 0 3px rgba(98, 70, 165, .08);
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        min-width: 650px;
    }

    .dashboard-table th,
    .dashboard-table td {
        padding: 15px 12px;
        border-bottom: 1px solid #edf0f5;
        font-size: 13px;
    }

    .dashboard-table th {
        color: #7b8496;
        background: #f8f7fb;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .dashboard-table td {
        color: #515b6e;
    }

    .dashboard-table tbody tr:hover {
        background: #faf9fd;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #eee9f8;
        color: #6246a5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: bold;
        flex-shrink: 0;
    }

    .student-name {
        font-weight: bold;
        color: #394154;
    }

    .status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .present {
        background: #e0f7ec;
        color: #168653;
    }

    .present .status-dot {
        background: #28a879;
    }

    .absent {
        background: #fde8e8;
        color: #c43c3c;
    }

    .absent .status-dot {
        background: #dc6262;
    }

    .empty {
        text-align: center;
        color: #929aaa !important;
        padding: 25px !important;
    }

    .no-results {
        display: none;
        text-align: center;
        padding: 22px;
        color: #929aaa;
        font-size: 13px;
    }

    @media (max-width: 1150px) {
        .cards {
            grid-template-columns: repeat(2, 1fr);
        }

        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 700px) {
        .welcome {
            align-items: flex-start;
            flex-direction: column;
            padding: 23px;
        }

        .cards {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .card {
            padding: 16px;
        }

        .card h2 {
            font-size: 25px;
        }

        .section {
            padding: 18px;
        }
    }

    @media (max-width: 420px) {
        .cards {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

    <!-- WELCOME BANNER -->
    <section class="welcome">
        <div>
            <h2>Welcome to StudentTrack!</h2>
            <p>Manage and monitor student attendance in one place.</p>

            <p class="welcome-date">
                {{ now()->format('F d, Y') }}
            </p>
        </div>

        <a href="{{ route('attendance.index') }}" class="welcome-btn">
            + Record Attendance
        </a>
    </section>

    <!-- SUMMARY CARDS -->
    <section class="cards">

        <div class="card blue">
            <div class="card-top">
                <p class="card-label">Total Students</p>

                <div class="icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="9" cy="8" r="4"/>
                        <path d="M3 21v-2a6 6 0 0 1 12 0v2"/>
                        <path d="M16 4.5a4 4 0 0 1 0 7.5"/>
                        <path d="M21 21v-2a6 6 0 0 0-4-5.65"/>
                    </svg>
                </div>
            </div>

            <h2>{{ $totalStudents }}</h2>
            <span class="card-subtext">Registered students</span>
        </div>

        <div class="card green">
            <div class="card-top">
                <p class="card-label">Present Today</p>

                <div class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                </div>
            </div>

            <h2>{{ $presentToday }}</h2>
            <span class="card-subtext">Marked present today</span>
        </div>

        <div class="card red">
            <div class="card-top">
                <p class="card-label">Absent Today</p>

                <div class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 6L6 18"/>
                        <path d="M6 6l12 12"/>
                    </svg>
                </div>
            </div>

            <h2>{{ $absentToday }}</h2>
            <span class="card-subtext">Marked absent today</span>
        </div>

        <div class="card purple">
            <div class="card-top">
                <p class="card-label">Attendance Rate</p>

                <div class="icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="7" cy="7" r="2.5"/>
                        <circle cx="17" cy="17" r="2.5"/>
                        <path d="M19 5L5 19"/>
                    </svg>
                </div>
            </div>

            <h2>{{ $attendanceRate }}%</h2>
            <span class="card-subtext">Based on today's records</span>
        </div>

    </section>

    <!-- CHARTS -->
    <section class="content-grid">

        <div class="section">
            <div class="section-header">
                <div>
                    <h3>Weekly Attendance</h3>
                    <p class="section-description">
                        Present and absent records this week
                    </p>
                </div>
            </div>

            <div class="chart-container">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <div>
                    <h3>Attendance Overview</h3>
                    <p class="section-description">
                        Today's attendance summary
                    </p>
                </div>
            </div>

            <div class="chart-container">
                <canvas id="overviewChart"></canvas>
            </div>
        </div>

    </section>

    <!-- RECENT ATTENDANCE -->
    <section class="section">

        <div class="section-header">
            <div>
                <h3>Recent Attendance Records</h3>
                <p class="section-description">
                    Latest five attendance records
                </p>
            </div>

            <a href="{{ route('attendance.history') }}" class="view-all">
                View All →
            </a>
        </div>

        <div class="table-tools">
            <input
                type="text"
                id="attendanceSearch"
                class="search-input"
                placeholder="Search student number or name..."
            >
        </div>

        <div class="table-wrap">
            <table class="dashboard-table" id="attendanceTable">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($recentAttendances as $attendance)

                        @php
                            $studentName = trim(
                                ($attendance->student->first_name ?? '') . ' ' .
                                ($attendance->student->last_name ?? '')
                            );

                            $initials = collect(explode(' ', $studentName))
                                ->filter()
                                ->take(2)
                                ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                                ->implode('');
                        @endphp

                        <tr class="attendance-row">
                            <td>
                                {{ $attendance->student->student_number ?? 'N/A' }}
                            </td>

                            <td>
                                <div class="student-info">
                                    <div class="avatar">
                                        {{ $initials ?: '?' }}
                                    </div>

                                    <span class="student-name">
                                        {{ $studentName ?: 'Unknown Student' }}
                                    </span>
                                </div>
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('M d, Y') }}
                            </td>

                            <td>
                                @if ($attendance->status === 'Present')
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

            <div class="no-results" id="noResults">
                No matching attendance records found.
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // WEEKLY ATTENDANCE CHART
    const weeklyLabels = @json($weeklyLabels);
    const weeklyPresent = @json($weeklyPresent);
    const weeklyAbsent = @json($weeklyAbsent);

    new Chart(document.getElementById('attendanceChart'), {
        type: 'bar',

        data: {
            labels: weeklyLabels,
            datasets: [
                {
                    label: 'Present',
                    data: weeklyPresent,
                    backgroundColor: '#28a879',
                    borderRadius: 5,
                    maxBarThickness: 25
                },
                {
                    label: 'Absent',
                    data: weeklyAbsent,
                    backgroundColor: '#dc6262',
                    borderRadius: 5,
                    maxBarThickness: 25
                }
            ]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        padding: 18
                    }
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    grid: {
                        color: '#f0f1f5'
                    }
                },

                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // TODAY'S ATTENDANCE OVERVIEW
    new Chart(document.getElementById('overviewChart'), {
        type: 'doughnut',

        data: {
            labels: ['Present', 'Absent'],
            datasets: [{
                data: [{{ $presentToday }}, {{ $absentToday }}],
                backgroundColor: ['#28a879', '#dc6262'],
                borderWidth: 0,
                hoverOffset: 5
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',

            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        padding: 20
                    }
                }
            }
        }
    });

    // SEARCH ATTENDANCE TABLE
    const searchInput = document.getElementById('attendanceSearch');
    const rows = document.querySelectorAll('.attendance-row');
    const noResults = document.getElementById('noResults');

    searchInput.addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        let visibleRows = 0;

        rows.forEach(function (row) {
            const matches = row.textContent.toLowerCase().includes(searchValue);

            row.style.display = matches ? '' : 'none';

            if (matches) {
                visibleRows++;
            }
        });

        noResults.style.display =
            visibleRows === 0 && rows.length > 0 ? 'block' : 'none';
    });
</script>
@endpush
