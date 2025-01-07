<?php

namespace App\Http\Controllers;

use App\Services\AssociatiService;
use Illuminate\Http\Request;
use App\Models\IscrizioneCorsi;
use Validator;
use Log;
use OpenApi\Attributes as OA;
use Illuminate\Support\Facades\DB;

class IscrizioniController extends Controller
{
    #[OA\Post(
        path: '/api/nuova-iscrizione',
        summary: 'Aggiunge un nuovo iscritto ad un corso',
        tags: ["gestione iscrizioni"],
        description: "inserisce i dati di un'iscrizione ad un corso'",
        requestBody: new OA\RequestBody(
            required: true,
            description: 'dati iscrizione',
            content: new OA\JsonContent(
                required: [
                    "associato_id",
                    "corso_id",
                    "data_iscrizione",
                    "pagato",

                ],
                properties: [
                    new OA\Property(property: "associato_id", type: "string", format: "text"),
                    new OA\Property(property: "corso_id", type: "string", format: "text"),
                    new OA\Property(property: "data_iscrizione", type: "date", format: "date"),
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
    public function creaIscrizione(Request $request, AssociatiService $associatiService){


        try {
            $validatedData = Validator::make($request->all(),[
                'corso_id' => 'required',
                'associato_id' => 'required',
                'data_iscrizione' => 'required',
                'pagato' => 'required',
            ],[
                'corso_id.required' => 'Il campo id_corso è obbligatorio',
                'associato_id.required' => 'Il campo id_iscritto è obbligatorio',
                'data_iscrizione.required' => 'Il campo data_iscrizione è obbligatorio',
                'pagato.required' => 'Il campo pagato è obbligatorio',
            ]);
            if(!$validatedData->fails()){
                Log::info('dati da inserire: ' . $request['corso_id'] . ' ' . $request['associato_id'] );

                IscrizioneCorsi::create([
                    'id' => uniqid(),
                    'corso_id' => $request['corso_id'],
                    'associato_id' => $request['associato_id'],
                    'data_iscrizione' => $request['data_iscrizione'],
                    'pagato' => $request['pagato'],
                ]);
                $associatiService->invioConfermaIscrizioneCorso($request['associato_id'], $request['corso_id']);
                return response()->json(['message' => 'iscrizione avvenuta correttamente'] , 200);
            }else{
                return response()->json(['message' => 'dati mancanti o non validi: '. $validatedData->errors()->getMessages()], 204);
            }
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    #[OA\Delete(
        path: '/api/elimina-iscrizione/{id}',
        summary: 'Elimina un \'iscrizione tramite id associato',
        tags: ["gestione iscrizioni"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "id dell\'associato da eliminare come iscrizione",
                schema: new OA\Schema(type: "string", minimum: 16, description: "id associato"),
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'iscrizione eliminata'),
            new OA\Response(response: 404, description: 'iscrizione non trovata'),
            new OA\Response(response: 500, description: 'errore dei dati ricevuti'),
        ]
    )]

    public function eliminaIscrizione(Request $request)
    {
        try{
            if (!empty($request['id'])) {
                IscrizioneCorsi::where('associato_id', $request['id'])->delete();
                return response()->json(['message' => 'iscrizione eliminata'], 200);
            }
            return response()->json(['message' => 'iscrizione non trovata'], 404);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    #[OA\Get(
        path: '/api/iscrizioni-per-corso/{id}',
        summary: 'Recupera tutti gli associati iscritti ad un corso selezionato',
        tags: ["gestione iscrizioni"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID del corso",
                schema: new OA\Schema(type: "string", description: "ID corso")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Lista delle iscrizioni',
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        type: "object",
                        properties: [
                            new OA\Property(property: "corso_id", type: "string", format: "text"),
                            new OA\Property(property: "titolo", type: "string", format: "text"),
                            new OA\Property(property: "nome", type: "string", format: "text"),
                            new OA\Property(property: "cognome", type: "string", format: "text"),
                            new OA\Property(property: "data_iscrizione", type: "string", format: "date"),
                            new OA\Property(property: "pagato", type: "boolean"),
                            new OA\Property(property: "associato_id", type: "string", format: "text"),
                        ]
                    )
                )
            ),
            new OA\Response(response: 204, description: 'Dati mancanti'),
            new OA\Response(response: 404, description: 'Corso non trovato'),
            new OA\Response(response: 500, description: 'Errore nel recupero della lista degli associati')
        ]
    )]

    public function listaIscrizioniPerCorso($id = null){
        try{

            if (is_null($id) || empty($id)) {
                return response()->json(['message' => 'Dati mancanti'], 204);
            }

            $iscrizioni = DB::table('iscrizione_corsi')
                ->join('corsi', 'iscrizione_corsi.corso_id', '=', 'corsi.id')
                ->join('associati', 'iscrizione_corsi.associato_id', '=', 'associati.id')
                ->select('iscrizione_corsi.corso_id', 'corsi.titolo', 'associati.nome', 'associati.cognome', 'iscrizione_corsi.data_iscrizione', 'iscrizione_corsi.pagato', 'iscrizione_corsi.associato_id')
                ->where('corso_id', $id)
                ->get();

            if($iscrizioni->isEmpty()){
                return response()->json(['message' => 'Corso non trovato'], 404);
            }
            return response()->json(['message' => $iscrizioni], 200);

        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    #[OA\Get(
        path: '/api/iscrizioni-per-associato/{id}',
        summary: 'Recupera tutti i corsi ai quali è iscritto l\'associato selezionato',
        tags: ["gestione iscrizioni"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID del'associato",
                schema: new OA\Schema(type: "string", description: "id associato")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Lista delle iscrizioni',
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        type: "object",
                        properties: [
                            new OA\Property(property: "corso_id", type: "string", format: "text"),
                            new OA\Property(property: "titolo", type: "string", format: "text"),
                            new OA\Property(property: "data_iscrizione", type: "string", format: "date"),
                            new OA\Property(property: "pagato", type: "boolean"),
                            new OA\Property(property: "associato_id", type: "string", format: "text"),
                        ]
                    )
                )
            ),
            new OA\Response(response: 204, description: 'Dati mancanti'),
            new OA\Response(response: 404, description: 'Associato non trovato'),
            new OA\Response(response: 500, description: 'Errore nel recupero della lista dei corsi')
        ]
    )]

    public function listaIscrizionePerAssociato($id = null){
        try{
            if (is_null($id) || empty($id)) {
                return response()->json(['message' => 'Dati mancanti'], 204);
            }

            $iscrizioni = DB::table('associati')
                ->join('iscrizione_corsi', 'associati.id', '=', 'iscrizione_corsi.associato_id')
                ->join('corsi', 'iscrizione_corsi.corso_id', '=', 'corsi.id')
                ->select('iscrizione_corsi.corso_id', 'corsi.titolo', 'iscrizione_corsi.data_iscrizione', 'iscrizione_corsi.pagato', 'iscrizione_corsi.associato_id')
                ->where('associato_id', $id)
                ->get();

            if($iscrizioni->isEmpty()){
                return response()->json(['message' => 'Associato non trovato'], 404);
            }

            return response()->json(['message' => $iscrizioni], 200);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
