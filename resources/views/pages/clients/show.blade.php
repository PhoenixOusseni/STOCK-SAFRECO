@extends('layouts.master')

@section('content')
    <div class="pagetitle">
        <div class="d-flex justify-content-between align-items-center">
            <div class="mx-0">
                <h1>Details du Client</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('gestions_clients.index') }}">Clients</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('gestions_clients.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <a href="{{ route('gestions_clients.edit', $client->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('gestions_clients.destroy', $client->id) }}" method="POST" style="display:inline;"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ? Cette action est irréversible.')">
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
            <!-- Informations du client -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-person-badge"></i> Informations du Client
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th width="200">Code Client:</th>
                                            <td><span class="badge bg-primary">{{ $client->code }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Type:</th>
                                            <td>{{ $client->type }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nom:</th>
                                            <td>{{ $client->nom ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Raison Sociale:</th>
                                            <td>{{ $client->raison_sociale ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Ville:</th>
                                            <td>{{ $client->ville ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th width="200">éléphone:</th>
                                            <td>
                                                @if ($client->telephone)
                                                    <i class="bi bi-telephone"></i> {{ $client->telephone }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>
                                                @if ($client->email)
                                                    <i class="bi bi-envelope"></i> {{ $client->email }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Adresse:</th>
                                            <td>
                                                @if ($client->adresse)
                                                    <i class="bi bi-geo-alt"></i> {{ $client->adresse }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Créé le:</th>
                                            <td>{{ $client->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Modifié le:</th>
                                            <td>{{ $client->updated_at->format('d/m/Y H:i') }}</td>
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
