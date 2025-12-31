@extends('layouts.master')

@section('content')
    <div class="pagetitle">
        <div class="d-flex justify-content-between align-items-center">
            <div class="mx-0">
                <h1>Détails du Fournisseur</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('gestions_fournisseurs.index') }}">Fournisseurs</a></li>
                        <li class="breadcrumb-item active">Détails</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('gestions_fournisseurs.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <a href="{{ route('gestions_fournisseurs.edit', $fournisseur->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('gestions_fournisseurs.destroy', $fournisseur->id) }}" method="POST"
                    style="display:inline;"
                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ? Cette action est irréversible.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <!-- Informations du fournisseur -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-building"></i> Informations du Fournisseur
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th width="200">Code Fournisseur:</th>
                                            <td><span class="badge bg-primary">{{ $fournisseur->code }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Type:</th>
                                            <td>{{ $fournisseur->type ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nom:</th>
                                            <td>{{ $fournisseur->nom }}</td>
                                        </tr>
                                        <tr>
                                            <th>Raison Sociale:</th>
                                            <td>{{ $fournisseur->raison_sociale ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Ville:</th>
                                            <td>{{ $fournisseur->ville ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th width="200">Téléphone:</th>
                                            <td>
                                                @if ($fournisseur->telephone)
                                                    <i class="bi bi-telephone"></i> {{ $fournisseur->telephone }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>
                                                @if ($fournisseur->email)
                                                    <i class="bi bi-envelope"></i> {{ $fournisseur->email }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Adresse:</th>
                                            <td>
                                                @if ($fournisseur->adresse)
                                                    <i class="bi bi-geo-alt"></i> {{ $fournisseur->adresse }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Créé le:</th>
                                            <td>{{ $fournisseur->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Modifié le:</th>
                                            <td>{{ $fournisseur->updated_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
