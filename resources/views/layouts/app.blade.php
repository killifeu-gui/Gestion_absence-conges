<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(to bottom, #f8f9fa, #fff);
        }

        .navbar {
            background: linear-gradient(90deg, #ffffff 0%, #f8f9fa 100%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #e9ecef;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            font-weight: 500;
            color: #495057 !important;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #667eea !important;
        }

        .nav-link.active {
            color: #667eea !important;
            border-bottom: 2px solid #667eea;
        }

        .dropdown-menu {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            color: #495057;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #667eea;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md sticky-top">
            <div class="container-fluid px-4">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <i class="bi bi-briefcase"></i> {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('agents.*') ? 'active' : '' }}" href="{{ route('agents.index') }}">
                                    <i class="bi bi-people"></i> Agents
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('absences.*') ? 'active' : '' }}" href="{{ route('absences.index') }}">
                                    <i class="bi bi-x-circle"></i> Absences
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('leaves.*') ? 'active' : '' }}" href="{{ route('leaves.index') }}">
                                    <i class="bi bi-calendar-check"></i> Congés
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                                    <i class="bi bi-file-pdf"></i> Rapports
                                </a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right"></i> {{ __('Se connecter') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="bi bi-person-plus"></i> {{ __('S\'inscrire') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-person-circle me-2"></i>
                                    <span>{{ Auth::user()->name }}</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <h6 class="dropdown-header">
                                        <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            {{ Auth::user()->role === 'admin' ? 'Administrateur' : 'Gestionnaire' }}
                                        </span>
                                    </h6>
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        <i class="bi bi-speedometer2"></i> Tableau de bord
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right"></i> {{ __('Déconnexion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
