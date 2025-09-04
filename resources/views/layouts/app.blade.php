<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <style>
        body {
            background: #f4f6fa;
            font-family: 'Montserrat', Arial, sans-serif;
        }
        .sidebar {
            width: 260px;
            background: #18477b;
            color: #fff;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 30px 0 0 0;
            box-shadow: 2px 0 8px rgba(0,0,0,0.04);
        }
        .sidebar h2 {
            font-size: 1.35rem;
            font-weight: bold;
            margin-bottom: 2rem;
            margin-left: 20px;
            letter-spacing: 1px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin-left: 30px;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li span {
            font-size: 1.15rem;
            font-weight: bold;
            color: #fff;
            margin-bottom: 10px;
            display: block;
        }
        .sidebar .submenu {
            margin-left: 20px;
            margin-top: 5px;
        }
        .sidebar .submenu li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1.08rem;
            font-weight: 500;
            padding: 2px 8px;
            border-radius: 8px;
            transition: background 0.2s, color 0.2s;
            display: block;
        }
        .sidebar ul li a.active,
        .sidebar ul li a:hover {
            background: #2e5fa7;
            color: #fff;
            text-decoration: none;
        }
        .main-content {
            margin-left: 260px;
            padding: 40px 30px;
            background: #f4f6fa;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Module CRM</h2>
        <ul>
            <li>

                <ul class="submenu">
                     <span>Paramétrage</span>
                    <li>
                        <a href="{{ route('lots.index') }}" class="{{ request()->routeIs('lots.*') ? 'active' : '' }}">
                            Lots
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sous_lots.index') }}" class="{{ request()->routeIs('sous_lots.*') ? 'active' : '' }}">
                            Sous Lots
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('articles.index') }}" class="{{ request()->routeIs('articles.*') ? 'active' : '' }}">
                            Articles
                        </a>
                    </li>
   <li>
     <span>ventes</span>
                    <a href="{{route('devis.index')}}" class="{{ request()->routeIs('devis.*') ? 'active' : '' }}">
                        Devis
                    </a>
                </li>
                   <li>
                    <a href="{{ route('bl.index') }}"
                class="nav-link {{ request()->routeIs('bl.*') ? 'active' : '' }}">
                    <i class="fas fa-truck-loading"></i> Bons de Livraison
                </a>
                </li>
                <li>
                    <a href="{{ route('factures.index') }}"
                class="nav-link {{ request()->routeIs('factures.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar"></i> Factures
                </a>
                </li>
                <li>
                    <a href="{{ route('paiements.index') }}"
                class="nav-link {{ request()->routeIs('paiements.*') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave"></i> Paiements
                </a>
                </li>

                </ul>
                 </li>

        </ul>

    </div>

    <!-- Main content -->
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
@yield('scripts')
</body>
</html>
