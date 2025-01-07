<!-- filepath: /C:/MAMP/htdocs/digilab-be/resources/views/tessera.blade.php -->
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tessera</title>
    <style>
        .tessera-container {
            width: 184.25pt;
            /* 65 mm */
            height: 127.56pt;
            /* 45 mm */
            padding: 0.5rem;
            /* 2 * 0.25rem */
            background-color: #ffffff;
            border: 1px solid #000000;
            border-radius: 0.5rem;
            /* 8px */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            transition: background-color 0.2s;
        }

        .tessera-container:hover {
            background-color: #f7fafc;
        }

        .tessera-container.dark {
            background-color: #2d3748;
            border-color: #4a5568;
        }

        .tessera-container.dark:hover {
            background-color: #4a5568;
        }

        .tessera-logo {
            width: 50%;
            /* Occupare metà della larghezza */
            height: auto;
        }

        .tessera-info {
            font-size: 0.75rem;
            /* 12px */
            width: 50%;
            /* Occupare metà della larghezza */
            text-align: left;
        }

        .tessera-title {
            margin-bottom: 0.25rem;
            /* 1 * 0.25rem */
            font-size: 0.75rem;
            /* 12px */
            font-weight: 700;
            color: #1a202c;
        }

        .tessera-title.dark {
            color: #ffffff;
        }

        .tessera-text {
            font-weight: 400;
            color: #4a5568;
        }

        .tessera-text.dark {
            color: #a0aec0;
        }
    </style>
</head>

<body>
    <div class="tessera-container">
        <table style="width: 100%; height: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <img class="tessera-logo" src="{{ public_path('storage/immagini/MatteoGianniello_logo.jpg') }}"
                        alt="Immagine logo">
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div class="tessera-info">
                        <h5 class="tessera-title">Tessera N° {{$n_tessera}}</h5>
                        <p class="tessera-text">{{$nome}} {{$cognome}}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>

