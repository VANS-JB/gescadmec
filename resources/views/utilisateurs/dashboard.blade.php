@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 text-center">
         <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#"></a>
            
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Bienvenue, {{ Auth::user()->name }}
                </span>
                
            </div>
        </div>
    </nav>
    <div class="card-body">
                        <p class="card-text">Vous êtes connecté avec succès !</p>
                        <div class="alert alert-success">
                            <strong>Email :</strong> {{ Auth::user()->email }}<br>
                            <strong>Nom :</strong> {{ Auth::user()->name }}<br>
                            <strong>Inscrit le :</strong> {{ Auth::user()->created_at->format('d/m/Y') }}
                        </div>
        <h1 class="display-4 mb-4">
            <i class="fas fa-language text-primary"></i><br>
            Bienvenue à GESCADMEC
        </h1>
        <p class="lead">Système de gestion des inscriptions et paiements</p>
        
        <div class="row mt-5">
            <div class="col-md-3 mb-4">
                <div class="card border-primary h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Étudiants</h5>
                        <p class="card-text">Gérer les étudiants inscrits</p>
                        <a href="{{ route('etudiants.index') }}" class="btn btn-primary">Voir les étudiants</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card border-success h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-clipboard-list fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Inscriptions</h5>
                        <p class="card-text">Nouvelles inscriptions</p>
                        <a href="{{ route('etudiants.create') }}" class="btn btn-success">Nouvelle inscription</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card border-warning h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-money-bill-wave fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Paiements</h5>
                        <p class="card-text">Gérer les paiements</p>
                        <a href="{{ route('paiements.index') }}" class="btn btn-warning">Voir les paiements</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card border-info h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-bar fa-3x text-info mb-3"></i>
                        <h5 class="card-title">Statistiques</h5>
                        <p class="card-text">Voir les statistiques</p>
                        <a href="{{ route('paiements.statistiques') }}" class="btn btn-info">Voir stats</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
