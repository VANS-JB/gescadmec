<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Académie de Langue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('utilisateurs.dashboard') }}">
                <i class="fas fa-language"></i> GESCADMEC
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('etudiants.index') }}">
                            <i class="fas fa-users"></i> Étudiants
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('inscriptions.index') }}">
                            <i class="fas fa-clipboard-list"></i> Inscriptions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('paiements.index') }}">
                            <i class="fas fa-money-bill-wave"></i> Paiements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('paiements.statistiques') }}">
                            <i class="fas fa-chart-bar"></i> Statistiques
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('besoins.index') }}">
                            <i class="fas fa-comments"></i> Besoins
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>