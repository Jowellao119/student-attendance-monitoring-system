<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'StudentTrack')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: #f5f6fa;
            color: #252b3b;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #fff;
            padding: 25px 18px;
            border-right: 1px solid #edf0f5;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .brand {
            font-size: 23px;
            font-weight: 700;
            margin: 0 0 35px 10px;
            color: #6246a5;
        }

        .brand span {
            color: #c0396b;
        }

        .menu-label {
            color: #a0a5b5;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            margin: 15px 10px 10px;
            text-transform: uppercase;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            margin-bottom: 6px;
            border-radius: 8px;
            color: #737b8c;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: .2s;
        }

        .menu-link:hover {
            background: #f2effa;
            color: #6246a5;
        }

        .menu-link.active {
            background: linear-gradient(135deg, #6246a5, #9b59b6);
            color: #fff;
        }

        .menu-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .menu-icon svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sidebar-bottom {
            margin-top: auto;
        }

        .logout-button {
            width: 100%;
            border: none;
            background: #fff0f0;
            color: #d35454;
            padding: 12px 14px;
            border-radius: 8px;
            cursor: pointer;
            text-align: left;
            font-family: inherit;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: .2s;
        }

        .logout-button:hover {
            background: #ffe5e5;
            color: #c0392b;
        }

        .main {
            margin-left: 250px;
            min-height: 100vh;
            padding: 30px 35px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .topbar h1 {
            font-size: 23px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .topbar p {
            color: #858b9a;
            font-size: 13px;
        }

        .user-pill {
            background: #fff;
            border: 1px solid #edf0f5;
            border-radius: 9px;
            padding: 11px 17px;
            font-size: 13px;
            font-weight: 600;
            color: #555d70;
            white-space: nowrap;
        }

        .page-footer {
            text-align: center;
            color: #a0a5b5;
            font-size: 12px;
            margin-top: 30px;
            padding: 15px 0;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 210px;
            }

            .main {
                margin-left: 210px;
                padding: 25px 20px;
            }
        }

        @media (max-width: 650px) {
            .sidebar {
                width: 65px;
                padding: 20px 8px;
            }

            .brand {
                font-size: 0;
                margin: 0 0 30px;
                text-align: center;
            }

            .brand::first-letter {
                font-size: 23px;
            }

            .brand span,
            .menu-label,
            .menu-link span,
            .logout-button span {
                display: none;
            }

            .menu-link,
            .logout-button {
                justify-content: center;
                padding: 13px 8px;
            }

            .main {
                margin-left: 65px;
                padding: 20px 12px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .user-pill {
                white-space: normal;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">

        <div class="brand">
            Student<span>Track</span>
        </div>

        <div class="menu-label">Main Menu</div>

        <a href="{{ route('dashboard') }}"
           class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="menu-icon">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="8" height="8" rx="1"/>
                    <rect x="13" y="3" width="8" height="5" rx="1"/>
                    <rect x="13" y="10" width="8" height="11" rx="1"/>
                    <rect x="3" y="13" width="8" height="8" rx="1"/>
                </svg>
            </div>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('students.index') }}"
           class="menu-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
            <div class="menu-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <span>Students</span>
        </a>

        <a href="{{ route('attendance.index') }}"
           class="menu-link {{ request()->routeIs('attendance.index') ? 'active' : '' }}">
            <div class="menu-icon">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="17" rx="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18"/>
                    <path d="m9 16 2 2 4-4"/>
                </svg>
            </div>
            <span>Attendance</span>
        </a>

        <a href="{{ route('attendance.history') }}"
           class="menu-link {{ request()->routeIs('attendance.history') ? 'active' : '' }}">
            <div class="menu-icon">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 2"/>
                </svg>
            </div>
            <span>Attendance History</span>
        </a>

        <a href="{{ route('reports.index') }}"
           class="menu-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <div class="menu-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M3 3v18h18"/>
                    <path d="m18 17-5-5-4 4-4-4"/>
                </svg>
            </div>
            <span>Reports</span>
        </a>

        <div class="menu-label">Account</div>

        <a href="{{ route('profile.edit') }}"
           class="menu-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <div class="menu-icon">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                </svg>
            </div>
            <span>Profile Settings</span>
        </a>

        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="logout-button">
                    <div class="menu-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <path d="M16 17l5-5-5-5"/>
                            <path d="M21 12H9"/>
                        </svg>
                    </div>
                    <span>Logout</span>
                </button>
            </form>
        </div>

    </aside>

    <main class="main">

        <header class="topbar">
            <div>
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>@yield('page-subtitle', 'Welcome to StudentTrack.')</p>
            </div>

            <div class="user-pill">
                {{ Auth::user()?->name ?? 'Guest' }}
            </div>
        </header>

        @yield('content')

        <footer class="page-footer">
            Student Attendance Monitoring System © {{ date('Y') }}
        </footer>

    </main>

    @stack('scripts')

</body>
</html>
