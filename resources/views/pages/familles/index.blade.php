@extends('layouts.master')
@section('content')
    <div class="pagetitle">
        <div class="d-flex justify-content-between align-items-center">
            <div class="mx-0">
                <h1>Gestion des groupes d'immobilisation</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Gestion des groupes d'immobilisation</li>
                    </ol>
                </nav>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFamilyModal">
                <i class="bi bi-plus-circle"></i>&nbsp; Ajouter un groupe d'immobilisation
            </button>

            <!-- Modal -->
            <div class="modal fade" id="addFamilyModal" tabindex="-1" aria-labelledby="addFamilyModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addFamilyModalLabel">Ajouter un nouveau groupe d'immobilisation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('gestions_familles.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="designation" class="form-label">Nom du groupe d'immobilisation</label>
                                    <input type="text" class="form-control" id="designation" name="designation" required>
                                </div>
                                <div class="mb-3">
                                    <label for="taux_amortissement" class="form-label">Taux d'amortissement (%)</label>
                                    <input type="number" step="0.01" class="form-control" id="taux_amortissement"
                                        name="taux_amortissement" required>
                                </div>
                            </div>
                            <div class="mx-3 mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i>&nbsp; Enregistrer
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle"></i>&nbsp; Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Liste des groupes d'immobilisation</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Code groupe</th>
                                    <th scope="col">Nom du groupe</th>
                                    <th scope="col">Taux d'amortissement</th>
                                    <th>Nombre d'actifs</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($familles as $famille)
                                    <tr>
                                        <th scope="row">{{ $famille->id }}</th>
                                        <td>{{ $famille->code }}</td>
                                        <td>{{ $famille->designation }}</td>
                                        <td>{{ $famille->taux_amortissement }}%</td>
                                        <td>{{ $famille->articles->count() }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('gestions_familles.show', $famille->id) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
