<!-- filepath: /c:/MAMP/htdocs/digilab-be/resources/views/mail/confermaIscrizione.blade.php -->
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferma Iscrizione al Corso</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <div class="text-center border-b pb-4">
            <h1 class="text-2xl font-bold">Conferma Iscrizione al Corso</h1>
        </div>
        <div class="mt-4">
            <p class="text-lg">Caro {{ $nome }} {{ $cognome }},</p>
            <p class="mt-2">Siamo lieti di confermare la tua iscrizione al corso <strong>{{ $corso }}</strong>.
                Benvenuto!</p>
            <p class="mt-4">Di seguito i dettagli del corso:</p>
            <ul class="list-disc list-inside mt-2">
                <li><strong>Nome del Corso:</strong> {{ $corso }}</li>
                <li><strong>Data di Inizio:</strong> {{ $data_inizio }}</li>
                <!-- Aggiungi altre informazioni se necessario -->
            </ul>
            <p class="mt-4">Grazie per esserti iscritto al nostro corso. Non vediamo l'ora di vederti!</p>
        </div>
        <div class="text-center border-t pt-4 mt-4 text-gray-600 text-sm">
            <p>&copy; {{ date('Y') }} La Nostra Associazione. Tutti i diritti riservati.</p>
        </div>
    </div>
</body>

</html>
