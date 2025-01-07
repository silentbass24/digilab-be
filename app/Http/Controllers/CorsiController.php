<?php

namespace App\Http\Controllers;

use App\Models\Corsi;
use Log;
use OpenApi\Attributes as OA;
use Illuminate\Http\Request;
use Validator;


class CorsiController extends Controller
{
    #[OA\Get(
        path: '/api/lista-corsi',
        summary: 'Recupera la lista dei corsi',
        tags:["gestione corsi"],
        responses: [
            new OA\Response(response: 200, description: 'lista corsi'),
            new OA\Response(response: 500, description: 'Errore nel recupero della lista degli associati'),
        ]
    )]

    public function recuperaListaCorsi(){
        try {
            $data = Corsi::all();
            return response()->json(['message' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    #[OA\Post(
        path: '/api/nuovo-corso',
        summary: 'Aggiunge un nuovo corso',
        tags: ["gestione corsi"],
        description: "inserisce i dati di un nuovo corso nel database",
        requestBody: new OA\RequestBody(
            required: true,
            description: 'dati corso',
            content: new OA\JsonContent(
                required: [
                    "titolo",
                    "descrizione",
                    "data_inizio",
                    "data_fine",
                    "costo",

                ],
                properties: [
                    new OA\Property(property: "titolo", type: "string", format: "text"),
                    new OA\Property(property: "descrizione", type: "string", format: "text"),
                    new OA\Property(property: "data_inizio", type: "string", format: "date"),
                    new OA\Property(property: "data_fine", type: "string", format: "text"),
                    new OA\Property(property: "costo", type: "string", format: "text"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'corso aggiunto'),
            new OA\Response(response: 204, description: 'dati mancanti o non validi'),
            new OA\Response(response: 500, description: 'Errore nell\'inserimento del nuovo corso'),
        ]
    )]

    public function addNuovoCorso(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'titolo' => 'required|string|max:255',
                'descrizione' => 'required|string',
                'data_inizio' => 'required|date',
                'data_fine' => 'required|date',
                'costo' => 'required',
            ], [
                'titolo.required' => 'Inserire un titolo per il corso',
                'titolo.string' => 'Il campo titolo non accetta cartatteri speciali',
                'data_inizio.required' => 'Inserire una data di inizio',
                'data_fine.required' => 'Inserire una data di fine',
                'costo.required' => 'Inserire un corso',
            ]);
            if (!$validatedData->fails()) {
                Corsi::create([
                    'id' => uniqid(),
                    'titolo' => $request['titolo'],
                    'descrizione' => $request['descrizione'],
                    'data_inizio' => $request['data_inizio'],
                    'data_fine' => $request['data_fine'],
                    'costo' => $request['costo'],
                ]);
                return response()->json(['message' => 'corso aggiunto'], 200);
            }

            return response()->json(['message' => 'dati mancanti o non validi: '.$validatedData->errors()], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'errore nell\'aggiunta del corso: '. $e->getMessage()], 500);
        }
    }

    #[OA\Delete(
        path: '/api/elimina-corso/{id}',
        summary: 'Elimina un corso tramite il suo id',
        tags: ["gestione corsi"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "id del corso da eliminare",
                schema: new OA\Schema(type: "string", minimum: 16, description: "id corso"),
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'corso eliminato'),
            new OA\Response(response: 404, description: 'corso non trovato'),
        ]
    )]

    public function eliminaCorso(Request $request)
    {
        if (!empty($request['id'])) {
            Corsi::where('id', $request['id'])->delete();
            return response()->json(['message' => 'corso eliminato'], 200);
        }
        return response()->json(['message' => 'corso non trovato'], 404);
    }

    #[OA\Get(
        path: '/api/corso/{id}',
        summary: 'Recupera un corso tramite il suo id',
        tags: ["gestione corsi"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "id del corso da recuperare",
                schema: new OA\Schema(type: "string", minimum: 16, description: "id corso"),
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'dati del corso'),
            new OA\Response(response: 404, description: 'corso non trovato'),
            new OA\Response(response: 500, description: 'errore nella richiesta'),
        ]
    )]

    public function ottieniCorso(Request $request)
    {
        // Log::info('dati ricevuti: '.$request);
        try{
            if (!empty($request['id'])) {
                $data = Corsi::where('id', $request['id'])->get();
                return response()->json(['message' => $data], 200);
            }
            return response()->json(['message' => 'corso non trovato'], 404);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);

        }
    }

    #[OA\Put(
        path: '/api/modifica-corso/{id}',
        summary: 'Modifica corso',
        tags: ["gestione corsi"],
        description: "modifica i dati del corso nel database",
        requestBody: new OA\RequestBody(
            required: true,
            description: 'dati corso',
            content: new OA\JsonContent(
                required: [
                    "id",
                    "titolo",
                    "descrizione",
                    "data_inizio",
                    "data_fine",
                    "costo"
                ],
                properties: [
                    new OA\Property(property: "titolo", type: "string", format: "text"),
                    new OA\Property(property: "descrizione", type: "string", format: "text"),
                    new OA\Property(property: "data_inizio", type: "string", format: "date"),
                    new OA\Property(property: "data_fine", type: "string", format: "date"),
                    new OA\Property(property: "costo", type: "string", format: "text"),
                ]
            )
        ),
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "id del corso da recuperare",
                schema: new OA\Schema(type: "string", minimum: 16, description: "id corso"),
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'corso aggiunto'),
            new OA\Response(response: 204, description: 'dati corso mancanti'),
            new OA\Response(response: 500, description: 'Errore nell\'aggiornamento del nuovo corso'),
        ]
    )]

    public function modificaCorso(Request $request)
    {
        if (!empty($request['id'])) {
            try {
                $validatedData = Validator::make($request->all(), [
                    'titolo' => 'required|string|max:255',
                    'descrizione' => 'required|string|max:255',
                    'data_inizio' => 'required|date',
                    'data_fine' => 'required|date',
                    'costo' => 'required',
                ], [
                    'titolo.required' => 'Inserire un titolo',
                    'titolo.string' => 'Il campo titolo non accetta cartatteri speciali',
                    'descrizione.required' => 'Inserire una descrizione',
                    'descrizione.string' => 'Il campo descrizione non accetta cartatteri speciali',
                    'costo.required' => 'Inserire il costo del corso',
                    'data_inizio.required' => 'Inserire una data di inizio',
                    'data_inizio.date' => 'Nel campo data inizio inserire una data',
                    'data_fine.required' => 'Inserire una data di fine',
                    'data_fine.date' => 'Nel campo data fine inserire una data',
                ]);
                if (!$validatedData->fails()) {
                    $data = Corsi::where('id', $request['id'])->get();
                    Corsi::where('id', $request['id'])->update([
                        'titolo' => $request['titolo'],
                        'descrizione' => $request['descrizione'],
                        'data_inizio' => $request['data_inizio'],
                        'data_fine' => $request['data_fine'],
                        'costo' => $request['costo'],
                    ]);
                    return response()->json(['message' => $data], 200);
                }
                return response()->json(['message' => $validatedData->errors()], 500);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
        return response()->json(['message' => 'corso non trovato'], 404);
    }

}
