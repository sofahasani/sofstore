<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Admin Dashboard') - Premium Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --gold: #D4AF37;
            --gold-dark: #B8941E;
            --dark-bg: #0E0E10;
            --dark-card: #1A1A1D;
            --dark-text: #E4E4E7;
            --light-bg: #F8F9FA;
            --light-card: #FFFFFF;
            --light-text: #1F2937;
            --orange: #FF7300;
            --orange-light: #FF9500;
            --sidebar-width: 260px;
            --sidebar-collapsed: 80px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--light-bg);
            color: var(--light-text);
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* Dark Mode */
        [data-theme="dark"] {
            background: var(--dark-bg);
            color: var(--dark-text);
        }

        [data-theme="dark"] .card {
            background: rgba(26, 26, 29, 0.7);
            border-color: rgba(255, 255, 255, 0.1);
        }

        [data-theme="dark"] .sidebar {
            background: linear-gradient(135deg, rgba(26, 26, 29, 0.95), rgba(14, 14, 16, 0.95));
            border-color: rgba(255, 255, 255, 0.1);
        }

        [data-theme="dark"] .header {
            background: rgba(26, 26, 29, 0.8);
            border-color: rgba(255, 255, 255, 0.1);
        }

        /* Layout */
        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.95));
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(0, 0, 0, 0.1);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 100;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        [data-theme="dark"] .sidebar-header {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--gold), var(--orange));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--gold);
            white-space: nowrap;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .sidebar-title {
            opacity: 0;
            width: 0;
        }

        .sidebar-menu {
            padding: 20px 12px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: inherit;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-bottom: 8px;
            position: relative;
        }

        .menu-item:hover {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(255, 115, 0, 0.1));
            transform: translateX(4px);
        }

        .menu-item.active {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(255, 115, 0, 0.15));
            color: var(--gold);
        }

        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 70%;
            background: linear-gradient(180deg, var(--gold), var(--orange));
            border-radius: 0 4px 4px 0;
        }

        .menu-icon {
            font-size: 20px;
            flex-shrink: 0;
        }

        .menu-text {
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            width: 0;
        }

        .toggle-sidebar {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--orange));
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }

        .toggle-sidebar:hover {
            transform: translateX(-50%) scale(1.1);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed);
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 20px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-left h1 {
            font-size: 24px;
            font-weight: 600;
            background: linear-gradient(135deg, var(--gold), var(--orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .theme-toggle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(212, 175, 55, 0.1);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background: linear-gradient(135deg, var(--gold), var(--orange));
            color: white;
            transform: rotate(20deg);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            border-radius: 50px;
            background: rgba(212, 175, 55, 0.1);
            transition: all 0.3s ease;
        }

        .admin-profile:hover {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(255, 115, 0, 0.15));
        }

        .admin-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--orange));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 32px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 24px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(212, 175, 55, 0.2);
        }

        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--gold), var(--orange));
            opacity: 0.1;
            border-radius: 0 20px 0 100%;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stat-icon.gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
        }

        .stat-icon.green {
            background: linear-gradient(135deg, #10B981, #059669);
        }

        .stat-title {
            font-size: 13px;
            font-weight: 500;
            opacity: 0.7;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--gold), var(--orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .stat-change {
            font-size: 12px;
            color: #10B981;
            font-weight: 500;
        }

        .stat-change.negative {
            color: #EF4444;
        }

        /* Charts Section */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        @media (max-width: 1024px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

        .chart-card {
            min-height: 350px;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .chart-header {
            margin-bottom: 20px;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .chart-subtitle {
            font-size: 13px;
            opacity: 0.6;
        }

        /* Table */
        .table-card {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            text-align: left;
            padding: 16px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.7;
            border-bottom: 2px solid rgba(212, 175, 55, 0.2);
        }

        tbody tr {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        [data-theme="dark"] tbody tr {
            border-color: rgba(255, 255, 255, 0.05);
        }

        tbody tr:hover {
            background: rgba(212, 175, 55, 0.05);
        }

        tbody td {
            padding: 16px;
            font-size: 14px;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge.success {
            background: rgba(16, 185, 129, 0.1);
            color: #10B981;
        }

        .badge.warning {
            background: rgba(245, 158, 11, 0.1);
            color: #F59E0B;
        }

        .badge.danger {
            background: rgba(239, 68, 68, 0.1);
            color: #EF4444;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .dashboard-content {
                padding: 20px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .header {
                padding: 16px 20px;
            }
        }

        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, rgba(0,0,0,0.06) 25%, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0.06) 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 8px;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">A</div>
                <div class="sidebar-title">Admin Panel</div>
            </div>
            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="menu-icon">📊</span>
                    <span class="menu-text">Dashboard</span>
                </a>
                <a href="{{ route('products.index') }}" class="menu-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <span class="menu-icon">📦</span>
                    <span class="menu-text">Produk</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <span class="menu-icon">🚚</span>
                    <span class="menu-text">Tracking Orders</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon">👥</span>
                    <span class="menu-text">Pelanggan</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon">📝</span>
                    <span class="menu-text">Laporan</span>
                </a>
                <a href="{{ route('dashboard') }}" class="menu-item">
                    <span class="menu-icon">👤</span>
                    <span class="menu-text">User</span>
                </a>
                <a href="{{ route('welcome') }}" class="menu-item">
                    <span class="menu-icon">🏠</span>
                    <span class="menu-text">Ke Toko</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon">⚙️</span>
                    <span class="menu-text">Pengaturan</span>
                </a>
            </nav>
            <button class="toggle-sidebar" id="toggleSidebar">
                <span id="toggleIcon">◀</span>
            </button>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <h1>@yield('page-title', 'Dashboard Overview')</h1>
                </div>
                <div class="header-right">
                    <button class="theme-toggle" id="themeToggle">
                        <span id="themeIcon">🌙</span>
                    </button>
                    <div class="admin-profile">
                        <div class="admin-avatar">A</div>
                        <div>
                            <div style="font-size: 14px; font-weight: 600;">Admin</div>
                            <div style="font-size: 12px; opacity: 0.6;">Super Admin</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        // Load saved theme
        const currentTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', currentTheme);
        themeIcon.textContent = currentTheme === 'dark' ? '☀️' : '🌙';

        themeToggle.addEventListener('click', () => {
            const newTheme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            themeIcon.textContent = newTheme === 'dark' ? '☀️' : '🌙';
        });

        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const toggleIcon = document.getElementById('toggleIcon');

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            toggleIcon.textContent = sidebar.classList.contains('collapsed') ? '▶' : '◀';
        });
    </script>

    @stack('scripts')
</body>
</html>
