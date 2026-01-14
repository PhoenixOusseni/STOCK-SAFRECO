@extends('layouts.master')

@section('content')
    <div class="pagetitle">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>Paramètres de l'Application</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Paramètres</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Page Title -->

    @include('pages.parametres.addedModal')

    <section class="section">
        <div class="row">
            <!-- Configuration Générale -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-gear"></i> Configuration Générale
                        </h5>

                        @php
                            $entete = \App\Models\Entete::first();
                        @endphp

                        <form action="{{ route('parametres.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="titre" class="form-label">Titre de l'Entreprise</label>
                                        <input type="text" class="form-control" id="titre" name="titre"
                                            value="{{ $entete->titre ?? 'SAFRECO-GSM' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sous_titre" class="form-label">Sous-titre</label>
                                        <input type="text" class="form-control" id="sous_titre" name="sous_titre"
                                            value="{{ $entete->sous_titre ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telephone" class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control" id="telephone" name="telephone"
                                            value="{{ $entete->telephone ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $entete->email ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="adresse" class="form-label">Adresse</label>
                                        <textarea class="form-control" id="adresse" name="adresse" rows="2">{{ $entete->adresse ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="logo" class="form-label">Logo de l'Entreprise</label>
                                        @if ($entete && $entete->logo)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $entete->logo) }}" alt="Logo"
                                                    style="max-height: 60px;">
                                            </div>
                                        @endif
                                        <input type="file" class="form-control" id="logo" name="logo"
                                            accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG (max 2MB)</small>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Enregistrer les modifications
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Imports de Données -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-download"></i> Importer les Clients
                        </h5>
                        <p class="text-muted">Importez les clients depuis un fichier CSV/Excel</p>

                        <form action="{{ route('clients.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="clients_file" class="form-label">Fichier Clients</label>
                                <input type="file" class="form-control" id="clients_file" name="file"
                                    accept=".csv,.xlsx,.xls" required>
                                <small class="text-muted">Formats acceptés: CSV, XLSX</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success flex-grow-1">
                                    <i class="bi bi-upload"></i> Importer
                                </button>
                                <a href="{{ route('clients.template') }}" class="btn btn-outline-secondary flex-grow-1">
                                    <i class="bi bi-file-earmark-spreadsheet"></i> Template
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-download"></i> Importer les Fournisseurs
                        </h5>
                        <p class="text-muted">Importez les fournisseurs depuis un fichier CSV/Excel</p>

                        <form action="{{ route('fournisseurs.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="fournisseurs_file" class="form-label">Fichier Fournisseurs</label>
                                <input type="file" class="form-control" id="fournisseurs_file" name="file"
                                    accept=".csv,.xlsx,.xls" required>
                                <small class="text-muted">Formats acceptés: CSV, XLSX</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success flex-grow-1">
                                    <i class="bi bi-upload"></i> Importer
                                </button>
                                <a href="{{ route('fournisseurs.template') }}"
                                    class="btn btn-outline-secondary flex-grow-1">
                                    <i class="bi bi-file-earmark-spreadsheet"></i> Template
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-download"></i> Importer des immobilisations
                        </h5>
                        <p class="text-muted">Importez les immobilisations depuis un fichier CSV/Excel</p>

                        <form action="{{ route('articles.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="articles_file" class="form-label">Fichier Immobilisations</label>
                                <input type="file" class="form-control" id="articles_file" name="file"
                                    accept=".csv,.xlsx,.xls" required>
                                <small class="text-muted">Formats acceptés: CSV, XLSX</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success flex-grow-1">
                                    <i class="bi bi-upload"></i> Importer
                                </button>
                                <a href="{{ route('articles.template') }}" class="btn btn-outline-secondary flex-grow-1">
                                    <i class="bi bi-file-earmark-spreadsheet"></i> Template
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-boxes"></i> Gestion des Stocks
                        </h5>
                        <div class="mb-3">
                            <label class="form-label">Importer les Stocks</label>
                            <p class="text-muted">Initialisez les stocks des articles par dépôt</p>
                            <form action="{{ route('stocks.import') }}" method="POST" enctype="multipart/form-data"
                                class="d-inline">
                                @csrf
                                <div class="input-group">
                                    <input type="file" class="form-control" name="file" accept=".csv,.xlsx,.xls"
                                        required>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-upload"></i> Importer
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-1">Template: Article ID, Dépôt ID, Quantité</small>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-boxes"></i> Importer groupe Immobilisation
                        </h5>
                        <div class="mb-3">
                            <label class="form-label">Importer groupes d'immobilisation</label>
                            <p class="text-muted">Initialisez les groupes d'immobilisation</p>
                            <form action="{{ route('familles.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="familles_file" class="form-label">Fichier Familles</label>
                                    <input type="file" class="form-control" id="familles_file" name="file"
                                        accept=".csv,.xlsx,.xls" required>
                                    <small class="text-muted">Formats acceptés: CSV, XLSX</small>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success flex-grow-1">
                                        <i class="bi bi-upload"></i> Importer
                                    </button>
                                    <a href="{{ route('familles.template') }}"
                                        class="btn btn-outline-secondary flex-grow-1">
                                        <i class="bi bi-file-earmark-spreadsheet"></i> Template
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maintenance -->
            <div class="col-lg-12">
                <div class="card border-warning">
                    <div class="card-body">
                        <h5 class="card-title text-warning">
                            <i class="bi bi-exclamation-triangle"></i> Maintenance
                        </h5>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <p class="text-muted">Vider le cache de l'application</p>
                                    <form action="{{ route('cache.clear') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning w-100">
                                            <i class="bi bi-trash"></i> Vider le Cache
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <p class="text-muted">Réinitialiser les logs</p>
                                    <form action="{{ route('logs.clear') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger w-100"
                                            onclick="return confirm('Êtes-vous sûr ?');">
                                            <i class="bi bi-trash"></i> Réinitialiser Logs
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <p class="text-muted">Exécuter les migrations</p>
                                    <form action="{{ route('migrate') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-info w-100">
                                            <i class="bi bi-arrow-repeat"></i> Migrer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aide et Documentation -->
            <div class="col-lg-12">
                <div class="card border-info">
                    <div class="card-body">
                        <h5 class="card-title text-info">
                            <i class="bi bi-question-circle"></i> Aide et Documentation
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-light">
                                    <h6 class="alert-heading"><i class="bi bi-file-earmark-pdf"></i> Formats d'Import</h6>
                                    <ul class="mb-0 small">
                                        <li><strong>CSV:</strong> Comma Separated Values (UTF-8)</li>
                                        <li><strong>XLSX:</strong> Excel 2007+ (.xlsx)</li>
                                        <li><strong>Colonnes requises:</strong> Voir le template</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="alert alert-light">
                                    <h6 class="alert-heading"><i class="bi bi-bulb"></i> Conseils</h6>
                                    <ul class="mb-0 small">
                                        <li>Téléchargez d'abord le template pour voir la structure</li>
                                        <li>Assurez-vous que les données sont valides avant l'import</li>
                                        <li>Les doublons seront automatiquement ignorés</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
