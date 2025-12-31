{{-- Composant pour afficher un code-barres --}}
@props(['codeBarre', 'designation' => '', 'prix' => '', 'showButtons' => true])

<div class="barcode-container">
    <div class="text-center bg-white p-3 rounded border">
        <svg id="barcode-{{ $codeBarre }}"></svg>
    </div>
    <p class="text-center mt-2 mb-0">
        <strong>{{ $codeBarre }}</strong>
    </p>
    @if($designation)
        <p class="text-center text-muted mb-0">{{ $designation }}</p>
    @endif
    @if($prix)
        <p class="text-center fw-bold mb-0">{{ number_format($prix, 0, ',', ' ') }} FCFA</p>
    @endif

    @if($showButtons)
    <div class="text-center mt-3">
        <button type="button" class="btn btn-sm btn-primary" onclick="printBarcode{{ str_replace(['CB', '-'], '', $codeBarre) }}()">
            <i class="bi bi-printer"></i> Imprimer
        </button>
        <button type="button" class="btn btn-sm btn-success" onclick="downloadBarcode{{ str_replace(['CB', '-'], '', $codeBarre) }}()">
            <i class="bi bi-download"></i> Télécharger
        </button>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        JsBarcode("#barcode-{{ $codeBarre }}", "{{ $codeBarre }}", {
            format: "CODE128",
            width: 2,
            height: 80,
            displayValue: false,
            margin: 10
        });
    });

    @if($showButtons)
    function printBarcode{{ str_replace(['CB', '-'], '', $codeBarre) }}() {
        const printWindow = window.open('', '', 'width=600,height=400');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Code-barres - {{ $codeBarre }}</title>
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
                    .info { margin-top: 20px; text-align: center; }
                    @media print { body { margin: 20px; } }
                </style>
            </head>
            <body>
                <svg id="printBarcode"></svg>
                <div class="info">
                    <h3>{{ $codeBarre }}</h3>
                    @if($designation)<p>{{ $designation }}</p>@endif
                    @if($prix)<p><strong>Prix: {{ number_format($prix, 0, ',', ' ') }} FCFA</strong></p>@endif
                </div>
                <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"><\/script>
                <script>
                    JsBarcode("#printBarcode", "{{ $codeBarre }}", {
                        format: "CODE128",
                        width: 2,
                        height: 80,
                        displayValue: false,
                        margin: 10
                    });
                    setTimeout(() => { window.print(); window.close(); }, 500);
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }

    function downloadBarcode{{ str_replace(['CB', '-'], '', $codeBarre) }}() {
        const svg = document.getElementById('barcode-{{ $codeBarre }}');
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
                a.download = 'code-barre-{{ $codeBarre }}.png';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            });
        };

        img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
    }
    @endif
</script>
@endpush
