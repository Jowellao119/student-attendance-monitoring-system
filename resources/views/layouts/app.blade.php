<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'StudentTrack')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

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
            background: #f3f6fc;
            color: #252b3b;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #172554 0%, #1e3a8a 55%, #164e63 100%);
            padding: 25px 17px 20px;
            border-right: 1px solid #263f78;
            display: flex;
            flex-direction: column;
            z-index: 100;
            box-shadow: 5px 0 25px rgba(15, 23, 42, .15);
            overflow-y: auto;
        }

        /* BRAND */
        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            margin: 0 0 34px 5px;
            padding: 3px 5px;
        }

        .brand-logo {
            width: 43px;
            height: 43px;
            border-radius: 13px;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 5px 15px rgba(6, 182, 212, .25);
        }

        .brand-name {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -.7px;
            color: #ffffff;
        }

        .brand-name span {
            color: #67e8f9;
        }

        .brand-caption {
            color: #bfdbfe;
            font-size: 10px;
            margin-top: 2px;
            letter-spacing: .5px;
        }

        /* MENU LABEL */
        .menu-label {
            color: #a5c4ed;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.2px;
            margin: 17px 12px 11px;
            text-transform: uppercase;
        }

        /* MENU LINKS */
        .menu-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 10px 13px;
            margin-bottom: 8px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: all .25s ease;
            border: 1px solid rgba(255,255,255,.08);
        }

        /* FULL MENU ROW COLORS */
        .menu-link.dashboard {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .menu-link.students {
            background: #cffafe;
            color: #0e7490;
        }

        .menu-link.attendance {
            background: #dcfce7;
            color: #15803d;
        }

        .menu-link.history {
            background: #fef3c7;
            color: #b45309;
        }

        .menu-link.reports {
            background: #fce7f3;
            color: #be185d;
        }

        .menu-link.profile {
            background: #ede9fe;
            color: #6d28d9;
        }

        /* MENU ICONS */
        .menu-icon {
            width: 36px;
            height: 36px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 18px;
            background: rgba(255,255,255,.8);
            transition: .25s;
        }

        /* HOVER */
        .menu-link:hover {
            transform: translateX(4px);
            filter: brightness(.94);
            box-shadow: 0 4px 12px rgba(0,0,0,.12);
        }

        .menu-link:hover .menu-icon {
            transform: scale(1.08);
        }

        /* ACTIVE MENU */
        .menu-link.active {
            background: linear-gradient(110deg, #2563eb, #0891b2);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 5px 15px rgba(8,145,178,.3);
        }

        .menu-link.active .menu-icon {
            background: rgba(255,255,255,.2);
        }

        .menu-link.active::before {
            content: "";
            position: absolute;
            left: -17px;
            top: 10px;
            bottom: 10px;
            width: 4px;
            background: #67e8f9;
            border-radius: 0 5px 5px 0;
        }

        /* SIDEBAR BOTTOM */
        .sidebar-bottom {
            margin-top: auto;
            padding-top: 15px;
            border-top: 1px solid rgba(255,255,255,.18);
        }

        /* LOGOUT */
        .logout-button {
            width: 100%;
            border: 1px solid rgba(255,255,255,.08);
            background: #fee2e2;
            color: #b91c1c;
            padding: 10px 13px;
            border-radius: 12px;
            cursor: pointer;
            text-align: left;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 13px;
            transition: .25s;
        }

        .logout-button:hover {
            background: #fecaca;
            transform: translateX(4px);
        }

        .logout-button .menu-icon {
            background: rgba(255,255,255,.8);
        }

        /* LOGOUT ICON */
        .logout-icon {
            font-size: 23px;
            font-weight: 600;
            line-height: 1;
        }

        /* MAIN CONTENT */
        .main {
            margin-left: 260px;
            min-height: 100vh;
            padding: 30px 35px;
        }

        /* TOPBAR */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 28px;
        }

        .topbar h1 {
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -.6px;
            color: #252b3b;
            margin-bottom: 5px;
        }

        .topbar p {
            color: #858b9a;
            font-size: 13px;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            border: 1px solid #edf0f5;
            border-radius: 12px;
            padding: 9px 15px 9px 9px;
            font-size: 13px;
            font-weight: 700;
            color: #555d70;
            white-space: nowrap;
            box-shadow: 0 3px 10px rgba(30, 30, 60, .025);
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, #dbeafe, #cffafe);
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        /* FOOTER */
        .page-footer {
            text-align: center;
            color: #a0a5b5;
            font-size: 12px;
            margin-top: 30px;
            padding: 18px 0;
            border-top: 1px solid #eceef3;
        }

        /* TABLET */
        @media (max-width: 1050px) {
            .sidebar {
                width: 230px;
            }

            .main {
                margin-left: 230px;
                padding: 25px 22px;
            }
        }

        /* MOBILE */
        @media (max-width: 650px) {
            .sidebar {
                width: 68px;
                padding: 20px 8px;
            }

            .brand {
                justify-content: center;
                margin: 0 0 28px;
                padding: 0;
            }

            .brand-logo {
                width: 42px;
                height: 42px;
            }

            .brand-info,
            .menu-label,
            .menu-link span,
            .logout-button span {
                display: none;
            }

            .menu-link {
                justify-content: center;
                padding: 9px 5px;
                gap: 0;
            }

            .menu-link.active::before {
                left: -8px;
            }

            .menu-icon {
                width: 40px;
                height: 40px;
            }

            .logout-button {
                justify-content: center;
                padding: 9px 5px;
            }

            .main {
                margin-left: 68px;
                padding: 20px 12px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .topbar h1 {
                font-size: 21px;
            }

            .user-pill {
                white-space: normal;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">

        <!-- BRAND -->
        <div class="brand">
            <div class="brand-logo">🎓</div>

            <div class="brand-info">
                <div class="brand-name">
                    Student<span>Track</span>
                </div>
                <div class="brand-caption">
                    ATTENDANCE MANAGEMENT
                </div>
            </div>
        </div>

        <!-- MAIN MENU -->
        <div class="menu-label">Main Menu</div>

        <a href="{{ route('dashboard') }}"
           class="menu-link dashboard {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="menu-icon">🏠</div>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('students.index') }}"
           class="menu-link students {{ request()->routeIs('students.*') ? 'active' : '' }}">
            <div class="menu-icon">👨‍🎓</div>
            <span>Students</span>
        </a>

        <a href="{{ route('attendance.index') }}"
           class="menu-link attendance {{ request()->routeIs('attendance.index') ? 'active' : '' }}">
            <div class="menu-icon">📝</div>
            <span>Attendance</span>
        </a>

        <a href="{{ route('attendance.history') }}"
           class="menu-link history {{ request()->routeIs('attendance.history') ? 'active' : '' }}">
            <div class="menu-icon">🕒</div>
            <span>Attendance History</span>
        </a>

        <a href="{{ route('reports.index') }}"
           class="menu-link reports {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <div class="menu-icon">📊</div>
            <span>Reports</span>
        </a>

        <!-- ACCOUNT -->
        <div class="menu-label">Account</div>

        <a href="{{ route('profile.edit') }}"
           class="menu-link profile {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <div class="menu-icon">⚙️</div>
            <span>Profile Settings</span>
        </a>

        <!-- LOGOUT -->
        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="logout-button">
                    <div class="menu-icon logout-icon">↪</div>
                    <span>Logout</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN -->
    <main class="main">

        <header class="topbar">
            <div>
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>@yield('page-subtitle', 'Welcome to StudentTrack.')</p>
            </div>

            <div class="user-pill">
                <div class="user-avatar">👤</div>
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
