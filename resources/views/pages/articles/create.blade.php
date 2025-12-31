@extends('layouts.master')
@section('title', 'Gestion des Articles')
@section('content')
    <div class="pagetitle">
        <div class="d-flex justify-content-between align-items-center">
            <div class="mx-0">
                <h1>Gestion des articles</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Gestion des articles</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('gestions_articles.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i>
            </a>
        </div>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-plus-circle"></i>&nbsp; Ajouter un nouveau article
                        </h5>
                        <form action="{{ route('gestions_articles.store') }}" method="POST">
                            @csrf
                            <!-- statut des articles -->
                            <div class="mb-4" style="background: rgb(232, 240, 243); padding: 10px; border-radius: 5px;">
                                <label class="small fw-bold">Type article</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="statut" id="type_amortissable" value="amortissable" required onchange="toggleFields()">
                                        <label class="form-check-label" for="type_amortissable">
                                            Amortissable
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="statut" id="type_non_amortissable" value="non amortissable" required onchange="toggleFields()">
                                        <label class="form-check-label" for="type_non_amortissable">
                                            Non Amortissable
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="code" class="small">Code</label>
                                    <input type="text" class="form-control" id="code" name="code" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="reference" class="small">Référence</label>
                                    <input type="text" class="form-control" id="reference" name="reference" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="designation" class="small">Designation</label>
                                    <input type="text" class="form-control" id="designation" name="designation" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="prix_achat" class="small">Valeur d'acquisition (FCFA)</label>
                                    <input type="number" class="form-control" id="prix_achat" name="prix_achat"
                                        step="0.01" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="prix_vente" class="small">Valeur de revente (FCFA)</label>
                                    <input type="number" class="form-control" id="prix_vente" name="prix_vente"
                                        step="0.01" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="date_entree" class="small">Date d'entrée en service</label>
                                    <input type="date" class="form-control" id="date_entree" name="date_entree" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="famille" class="small">Famille</label>
                                    <select class="form-select" id="famille" name="famille_id" required>
                                        <option value="" selected disabled>-- Sélectionner la famille --</option>
                                        @foreach ($familles as $famille)
                                            <option value="{{ $famille->id }}">{{ $famille->designation }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i>&nbsp; Enregistrer l'article
                                </button>
                                <button type="reset" class="btn btn-danger">
                                    <i class="bi bi-x-circle"></i>&nbsp; Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
