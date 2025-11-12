@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fas fa-chart-bar"></i> Statistiques par Niveau
    </h1>
    <a href="{{ route('paiements.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour aux paiements
    </a>
</div>

<div class="row">
    @foreach($statistiques as $stat)
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ $stat->niveau->nom }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Nombre d'inscriptions:</strong> {{ $stat->nombre_inscriptions }}</p>
                <p><strong>Total versé:</strong> {{ number_format($stat->total_verse, 0, ',', ' ') }} FCFA</p>
                <p><strong>Total restant:</strong> {{ number_format($stat->total_reste, 0, ',', ' ') }} FCFA</p>
                
                @php
                    $pourcentage = $stat->total_verse > 0 ? ($stat->total_verse / ($stat->total_verse + $stat->total_reste)) * 100 : 0;
                @endphp
                
                <div class="progress mt-3" style="height: 20px;">
                    <div class="progress-bar bg-success" role="progressbar" 
                         style="width: {{ $pourcentage }}%" 
                         aria-valuenow="{{ $pourcentage }}" aria-valuemin="0" aria-valuemax="100">
                        {{ number_format($pourcentage, 1) }}%
                    </div>
                </div>
                <small class="text-muted">Pourcentage de paiement</small>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="card mt-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">
            <i class="fas fa-chart-pie"></i> Résumé Global
        </h5>
    </div>
    <div class="card-body">
        @php
            $totalVerse = $statistiques->sum('total_verse');
            $totalReste = $statistiques->sum('total_reste');
            $totalInscriptions = $statistiques->sum('nombre_inscriptions');
            $pourcentageGlobal = $totalVerse > 0 ? ($totalVerse / ($totalVerse + $totalReste)) * 100 : 0;
        @endphp
        
        <div class="row text-center">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h3>{{ $totalInscriptions }}</h3>
                        <p>Total Inscriptions</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h3>{{ number_format($totalVerse, 0, ',', ' ') }} FCFA</h3>
                        <p>Total Versé</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h3>{{ number_format($totalReste, 0, ',', ' ') }} FCFA</h3>
                        <p>Total Restant</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h3>{{ number_format($pourcentageGlobal, 1) }}%</h3>
                        <p>Taux de Paiement</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection