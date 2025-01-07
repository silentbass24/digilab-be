<!-- filepath: /c:/MAMP/htdocs/digilab-be/resources/views/mail/confermaRichiestaAssociazione.blade.php -->
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferma Richiesta di Iscrizione</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <div class="text-center border-b pb-4">
            <h1 class="text-2xl font-bold">Conferma Richiesta di Iscrizione</h1>
        </div>
        <div class="mt-4">
            <p class="text-lg">Caro {{ $nome }} {{ $cognome }},</p>
            <p class="mt-2">Siamo lieti di informarti che la tua richiesta di iscrizione all'associazione è stata
                ricevuta correttamente.</p>
            <p class="mt-4">Il nostro team sta esaminando la tua richiesta e ti confermeremo l'associazione il prima
                possibile.</p>
            <p class="mt-4">Di seguito i tuoi dati di registrazione:</p>
            <ul class="list-disc list-inside mt-2">
                <li><strong>Nome:</strong> {{ $nome }}</li>
                <li><strong>Cognome:</strong> {{ $cognome }}</li>
                <li><strong>Email:</strong> {{ $email }}</li>
                <!-- Aggiungi altre informazioni se necessario -->
            </ul>
            <p class="mt-4">Grazie per il tuo interesse nella nostra associazione. Non vediamo l'ora di averti con noi!
            </p>
        </div>
        <div class="text-center border-t pt-4 mt-4 text-gray-600 text-sm">
            <p>&copy; {{ date('Y') }} La Nostra Associazione. Tutti i diritti riservati.</p>
        </div>
    </div>
</body>

</html>
