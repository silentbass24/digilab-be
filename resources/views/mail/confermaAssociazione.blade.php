<!-- filepath: /c:/MAMP/htdocs/digilab-be/resources/views/mail/confermaAssociazione.blade.php -->
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferma Associazione</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <div class="text-center border-b pb-4">
            <h1 class="text-2xl font-bold">Conferma Associazione</h1>
        </div>
        <div class="mt-4">
            <p class="text-lg">Caro {{ $nomeGenitore }} {{ $cognomeGenitore }},</p>
            <p class="mt-2">Siamo lieti di confermare la tua avvenuta associazione. Benvenuto nella nostra comunità!</p>
            <p class="mt-4">Di seguito i tuoi dati di registrazione:</p>
            <ul class="list-disc list-inside mt-2">
                <li><strong>Nome:</strong> {{ $nome }}</li>
                <li><strong>Cognome:</strong> {{ $cognome }}</li>
                <li><strong>Numero di tessera:</strong> {{ $numeroTessera }}</li>
                <!-- Aggiungi altre informazioni se necessario -->
            </ul>
            <p class="mt-4">Grazie per esserti associato con noi.</p>
        </div>
        <div class="text-center border-t pt-4 mt-4 text-gray-600 text-sm">
            <p>&copy; {{ date('Y') }} La Nostra Associazione. Tutti i diritti riservati.</p>
        </div>
    </div>
</body>

</html>
