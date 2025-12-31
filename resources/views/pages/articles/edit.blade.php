@extends('layouts.master')
@section('title', 'Gestion des Clients')
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
            <div class="d-flex gap-2">
                <a href="{{ route('gestions_articles.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <form action="{{ route('gestions_articles.destroy', $articleFinds->id) }}" method="POST"
                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Modification de l'article "{{ $articleFinds->code }}"</h5>

                        {{-- Code bar de l'article ajouté ici --}}
                        @if ($articleFinds->code_barre)
                            <div class="row align-items-start">
                                <div class="col-md-8">
                                    <div class="rounded">
                                        <svg id="barcode"></svg>
                                    </div>
                                    <p class="mb-4 mb-0">
                                        <strong>{{ $articleFinds->code_barre }}</strong>
                                    </p>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('gestions_articles.update', $articleFinds->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- statut des articles -->
                            <div class="mb-4" style="background: rgb(232, 240, 243); padding: 10px; border-radius: 5px;">
                                <label class="small fw-bold">Type article</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="statut" id="type_amortissable" value="amortissable" required onchange="toggleFields()" {{ $articleFinds->statut == 'amortissable' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_amortissable">
                                            Amortissable
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="statut" id="type_non_amortissable" value="non amortissable" required onchange="toggleFields()" {{ $articleFinds->statut == 'non amortissable' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_non_amortissable">
                                            Non Amortissable
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nom" class="small">Designation</label>
                                    <input type="text" class="form-control" id="nom" name="designation"
                                        value="{{ $articleFinds->designation }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="reference" class="small">Référence</label>
                                    <input type="text" class="form-control" id="reference" name="reference"
                                        value="{{ $articleFinds->reference }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="prix_achat" class="small">Prix d'Achat (FCFA)</label>
                                    <input type="number" class="form-control" id="prix_achat" name="prix_achat"
                                        step="0.01" value="{{ $articleFinds->prix_achat }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="prix_vente" class="small">Prix de Vente (FCFA)</label>
                                    <input type="number" class="form-control" id="prix_vente" name="prix_vente"
                                        step="0.01" value="{{ $articleFinds->prix_vente }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="date_entree" class="small">Date d'entrée en service</label>
                                    <input type="date" class="form-control" id="date_entree" name="date_entree" value="{{ $articleFinds->date_entree }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="famille" class="small">Famille</label>
                                    <select class="form-select" id="famille" name="famille_id" required>
                                        <option value="" selected disabled>-- Sélectionner la famille --</option>
                                        @foreach ($familles as $famille)
                                            <option value="{{ $famille->id }}"
                                                {{ $articleFinds->famille_id == $famille->id ? 'selected' : '' }}>
                                                {{ $famille->designation }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-pencil-square"></i>&nbsp; Mettre à jour l'article
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($articleFinds->code_barre)
        <!-- Inclure la bibliothèque JsBarcode depuis CDN -->
        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

        <script>
            // Générer le code-barres au chargement de la page
            document.addEventListener('DOMContentLoaded', function() {
                JsBarcode("#barcode", "{{ $articleFinds->code_barre }}", {
                    format: "CODE128",
                    width: 2,
                    height: 80,
                    displayValue: false,
                    margin: 10
                });
            });

            // Fonction pour imprimer le code-barres
            function printBarcode() {
                const printWindow = window.open('', '', 'width=600,height=400');
                const barcodeContent = document.getElementById('barcode').outerHTML;

                printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Code-barres - {{ $articleFinds->code_barre }}</title>
                    <style>
                        body {
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            margin: 0;
                            font-family: Arial, sans-serif;
                        }
                        .info {
                            margin-top: 20px;
                            text-align: center;
                        }
                        @media print {
                            body {
                                margin: 20px;
                            }
                        }
                    </style>
                </head>
                <body>
                    ${barcodeContent}
                    <div class="info">
                        <h3>{{ $articleFinds->code_barre }}</h3>
                        <p>{{ $articleFinds->designation }}</p>
                        <p><strong>Prix: {{ number_format($articleFinds->prix_vente, 0, ',', ' ') }} FCFA</strong></p>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"><\/script>
                    <script>
                        JsBarcode("#barcode", "{{ $articleFinds->code_barre }}", {
                            format: "CODE128",
                            width: 2,
                            height: 80,
                            displayValue: false,
                            margin: 10
                        });
                        setTimeout(() => {
                            window.print();
                            window.close();
                        }, 500);
                    <\/script>
                </body>
                </html>
            `);
                printWindow.document.close();
            }

            // Fonction pour télécharger le code-barres en PNG
            function downloadBarcode() {
                const svg = document.getElementById('barcode');
                const svgData = new XMLSerializer().serializeToString(svg);
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const img = new Image();

                img.onload = function() {
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.fillStyle = 'white';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0);

                    canvas.toBlob(function(blob) {
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'code-barre-{{ $articleFinds->code_barre }}.png';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        URL.revokeObjectURL(url);
                    });
                };

                img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
            }
        </script>
    @endif
@endsection
