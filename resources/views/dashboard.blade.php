@extends('layouts.app')

@section('title', 'StudentTrack | Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', "Welcome back! Here's your attendance overview.")

@push('styles')
<style>
    .welcome {
        position: relative;
        overflow: hidden;
        background: linear-gradient(120deg, #172554, #1d4ed8, #0891b2);
        color: white;
        padding: 32px;
        border-radius: 20px;
        margin-bottom: 26px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-shadow: 0 10px 28px rgba(29, 78, 216, .18);
    }

    .welcome::after {
        content: "🎓";
        position: absolute;
        right: 210px;
        bottom: -30px;
        font-size: 125px;
        opacity: .10;
        pointer-events: none;
    }

    .welcome h2 {
        margin-bottom: 10px;
        font-size: 25px;
        font-weight: 800;
    }

    .welcome p {
        font-size: 14px;
        opacity: .92;
        line-height: 1.6;
    }

    .welcome-date {
        margin-top: 13px;
        font-size: 12px !important;
        opacity: .8 !important;
    }

    .welcome-btn {
        position: relative;
        z-index: 1;
        background: white;
        color: #1d4ed8;
        text-decoration: none;
        padding: 13px 19px;
        border-radius: 11px;
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
        transition: .25s;
        box-shadow: 0 4px 12px rgba(0,0,0,.08);
    }

    .welcome-btn:hover {
        background: #cffafe;
        color: #0e7490;
        transform: translateY(-3px);
    }

    /* SUMMARY CARDS */
    .cards {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 26px;
    }

    .card {
        position: relative;
        overflow: hidden;
        background: white;
        padding: 23px 23px 23px 27px;
        border-radius: 17px;
        border: 1px solid #edf0f5;
        border-left: 5px solid #2563eb;
        box-shadow: 0 4px 15px rgba(30, 30, 60, .035);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .card::after {
        content: "";
        position: absolute;
        width: 95px;
        height: 95px;
        right: -35px;
        bottom: -48px;
        border-radius: 50%;
        background: currentColor;
        opacity: .035;
        pointer-events: none;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(30, 30, 60, .09);
    }

    .card.blue {
        border-left-color: #4388e8;
        color: #4388e8;
    }

    .card.green {
        border-left-color: #28a879;
        color: #28a879;
    }

    .card.red {
        border-left-color: #dc6262;
        color: #dc6262;
    }

    .card.purple {
        border-left-color: #0891b2;
        color: #0891b2;
    }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        gap: 10px;
    }

    .card-label {
        color: #7b8496;
        font-size: 13px;
        font-weight: 700;
    }

    .card h2 {
        color: #252b3b;
        font-size: 33px;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 7px;
    }

    .card-subtext {
        font-size: 11px;
        color: #a0a6b5;
    }

    .icon {
        width: 49px;
        height: 49px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        font-size: 26px;
        flex-shrink: 0;
        transition: transform .25s ease;
    }

    .card:hover .icon {
        transform: scale(1.12) rotate(-5deg);
    }

    .blue .icon { background: #e8f1ff; }
    .green .icon { background: #e0f7ec; }
    .red .icon { background: #fde8e8; }
    .purple .icon { background: #cffafe; }

    /* CHARTS AND CONTENT */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .section {
        background: white;
        padding: 24px;
        border-radius: 17px;
        border: 1px solid #edf0f5;
        box-shadow: 0 4px 15px rgba(30, 30, 60, .035);
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
        font-weight: 800;
        color: #30364a;
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
        color: #2563eb;
        text-decoration: none;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .view-all:hover {
        color: #0891b2;
        text-decoration: underline;
    }

    /* TABLE */
    .table-tools {
        margin-bottom: 17px;
    }

    .search-input {
        width: 100%;
        max-width: 340px;
        padding: 12px 15px;
        border: 1px solid #e2e5ec;
        border-radius: 10px;
        outline: none;
        font-size: 13px;
        transition: .2s;
    }

    .search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
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
        padding: 16px 12px;
        border-bottom: 1px solid #edf0f5;
        font-size: 13px;
    }

    .dashboard-table th {
        color: #64748b;
        background: #eff6ff;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .dashboard-table td {
        color: #515b6e;
    }

    .dashboard-table tbody tr {
        transition: background .2s;
    }

    .dashboard-table tbody tr:hover {
        background: #f0f9ff;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 10px;
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
        font-size: 11px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .student-name {
        font-weight: 700;
        color: #394154;
    }

    /* ATTENDANCE STATUS */
    .status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    .status-dot {
        width: 7px;
        height: 7px;
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

    /* RESPONSIVE DESIGN */
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
            padding: 24px;
        }

        .welcome::after {
            right: 15px;
            font-size: 90px;
        }

        .cards {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .card {
            padding: 16px 16px 16px 20px;
        }

        .card h2 {
            font-size: 27px;
        }

        .card-label {
            font-size: 12px;
        }

        .icon {
            width: 42px;
            height: 42px;
            font-size: 22px;
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
            <h2>Welcome to StudentTrack! 👋</h2>
            <p>Manage and monitor student attendance in one place.</p>

            <p class="welcome-date">
                📅 {{ now()->format('F d, Y') }}
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
                <div class="icon">👨‍🎓</div>
            </div>
            <h2>{{ $totalStudents }}</h2>
            <span class="card-subtext">Registered students</span>
        </div>

        <div class="card green">
            <div class="card-top">
                <p class="card-label">Present Today</p>
                <div class="icon">✅</div>
            </div>
            <h2>{{ $presentToday }}</h2>
            <span class="card-subtext">Marked present today</span>
        </div>

        <div class="card red">
            <div class="card-top">
                <p class="card-label">Absent Today</p>
                <div class="icon">❌</div>
            </div>
            <h2>{{ $absentToday }}</h2>
            <span class="card-subtext">Marked absent today</span>
        </div>

        <div class="card purple">
            <div class="card-top">
                <p class="card-label">Attendance Rate</p>
                <div class="icon">📊</div>
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
                    <h3>📈 Weekly Attendance</h3>
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
                    <h3>📊 Attendance Overview</h3>
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
                <h3>🕒 Recent Attendance Records</h3>
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
                placeholder="🔍 Search student number or name..."
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
                    borderRadius: 7,
                    maxBarThickness: 28
                },
                {
                    label: 'Absent',
                    data: weeklyAbsent,
                    backgroundColor: '#dc6262',
                    borderRadius: 7,
                    maxBarThickness: 28
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
                    ticks: { precision: 0 },
                    grid: { color: '#f0f1f5' }
                },

                x: {
                    grid: { display: false }
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
                hoverOffset: 7
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
