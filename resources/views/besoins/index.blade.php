@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fas fa-comments"></i> Besoins des Étudiants
    </h1>
    <a href="{{ route('besoins.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Nouveau Besoin
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Étudiant</th>
                        <th>Description</th>
                        <th>Date Soumission</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($besoins as $besoin)
                    <tr>
                        <td>{{ $besoin->id }}</td>
                        <td>
                            <strong>{{ $besoin->etudiant->nom }} {{ $besoin->etudiant->prenom }}</strong>
                        </td>
                        <td>
                            <div style="max-width: 300px;">
                                {{ Str::limit($besoin->description, 100) }}
                                @if(strlen($besoin->description) > 100)
                                    <button class="btn btn-sm btn-link p-0" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalDescription{{ $besoin->id }}">
                                        Voir plus
                                    </button>
                                @endif
                            </div>
                        </td>
                        <td>{{ $besoin->date_soumission_formatee }}</td>
                        <td>
                            <span class="badge 
                                @if($besoin->statut == 'résolu') bg-success
                                @elseif($besoin->statut == 'en_cours') bg-warning
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($besoin->statut) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                        data-bs-toggle="dropdown">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" 
                                           onclick="changerStatut({{ $besoin->id }}, 'en_attente')">
                                            <i class="fas fa-clock"></i> En attente
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" 
                                           onclick="changerStatut({{ $besoin->id }}, 'en_cours')">
                                            <i class="fas fa-spinner"></i> En cours
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" 
                                           onclick="changerStatut({{ $besoin->id }}, 'résolu')">
                                            <i class="fas fa-check"></i> Résolu
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" 
                                           onclick="supprimerBesoin({{ $besoin->id }})">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal pour la description complète -->
                    <div class="modal fade" id="modalDescription{{ $besoin->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Description complète</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Étudiant:</strong> {{ $besoin->etudiant->nom }} {{ $besoin->etudiant->prenom }}</p>
                                    <p><strong>Date:</strong> {{ $besoin->date_soumission_formatee }}</p>
                                    <p><strong>Description:</strong></p>
                                    <p>{{ $besoin->description }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($besoins->isEmpty())
        <div class="text-center py-4">
            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
            <p class="text-muted">Aucun besoin enregistré pour le moment.</p>
            <a href="{{ route('besoins.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Enregistrer le premier besoin
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function changerStatut(besoinId, statut) {
    if (confirm('Êtes-vous sûr de vouloir changer le statut de ce besoin ?')) {
        fetch(`/besoins/${besoinId}/statut`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ statut: statut })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function supprimerBesoin(besoinId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce besoin ?')) {
        fetch(`/besoins/${besoinId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
}
</script>
@endpush