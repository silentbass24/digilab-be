<?php

namespace App\Http\Controllers;

use App\Models\Associati;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;

use OpenApi\Attributes as OA;
use PHPUnit\Framework\Constraint\IsEmpty;
use Validator;
use Illuminate\Support\Facades\Log;

#[OA\Info(
    title: "API Associati digilab",
    version: "0.1",
    description:"Api per la gestione degli associati del digilab"
    )]

class AssociatiController extends Controller
{
    #[OA\Get(
        path: '/api/associati',
        summary: 'Recupera la lista degli associati',
        tags:["gestione associati"],
        responses: [
            new OA\Response(response: 200, description: 'lista associati'),
            new OA\Response(response: 500, description: 'Errore nel recupero della lista degli associati'),
        ]
    )]
    public function getAllAssociati()
    {

        try {
            $data = Associati::all();
            return response()->json(['message' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    #[OA\Post(
        path: '/api/nuovo-associato',
        summary: 'Aggiunge un nuovo associato',
        tags: ["gestione associati"],
        description:"inserisce i dati della richiesta di associazione nel database",
        requestBody:new OA\RequestBody(
            required: true,
            description: 'dati associato',
            content: new OA\JsonContent(
                required: [
                    "nome",
                    "cognome",
                    "codice_fiscale",
                    "nome_genitore",
                    "cognome_genitore",
                    "telefono",
                    "email",
                    "indirizzo",
                    "citta",
                    "provincia",
                    "cap",
                    "data_nascita"
                ],
                properties: [
                    new OA\Property(property: "nome", type: "string", format: "text"),
                    new OA\Property(property: "cognome", type: "string", format: "text"),
                    new OA\Property(property: "codice_fiscale", type: "string", format: "text"),
                    new OA\Property(property: "nome_genitore", type: "string", format: "text"),
                    new OA\Property(property: "cognome_genitore", type: "string", format: "text"),
                    new OA\Property(property: "telefono", type: "string", format: "text"),
                    new OA\Property(property: "email", type: "string", format: "text"),
                    new OA\Property(property: "indirizzo", type: "string", format: "text"),
                    new OA\Property(property: "citta", type: "string", format: "text"),
                    new OA\Property(property: "provincia", type: "string", format: "text"),
                    new OA\Property(property: "cap", type: "string", format: "text"),
                    new OA\Property(property: "data_nascita", type: "string", format: "date")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'associato aggiunto'),
            new OA\Response(response: 500, description: 'Errore nell\'inserimento del nuovo associato'),
        ]
    )]

    public function addNuovoAssociato(Request $request){
        $validatedData = Validator::make($request->all(),[
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'codice_fiscale' => 'required|string|max:16|unique:associati',
            'nome_genitore' => 'required|string|max:255',
            'cognome_genitore' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|email',
            'indirizzo' => 'required|string|max:255',
            'citta' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'cap' => 'required|string|max:5',
            'data_nascita'=> 'required|date',
        ],[
            'nome.required' => 'Inserire un nome',
            'nome.string' => 'Il campo nome non accetta cartatteri speciali',
            'cognome.required' => 'Inserire un cognome',
            'cognome.string' => 'Il campo cognome non accetta cartatteri speciali',
            'codice_fiscale.required' => 'Inserire il codice fiscale dell\'associato',
            'codice_fiscale.string' => 'Il campo codice fiscale non accetta cartatteri speciali',
            'codice_fiscale.unique' => 'Il codice fiscale inserito è già presente',
            'nome_genitore.required'=> 'Inserire il nome del genitore di riferimento',
            'nome_genitore.string'=> 'Il campo nome genitore non accetta cartatteri speciali',
            'cognome_genitore'=> 'Inserire il cognome del genitore di riferimento',
            'cognome_genitore.string'=> 'Il campo cognome genitore non accetta cartatteri speciali',
            'telefono.required'=> 'Inserire un contatto telefonico',
            'telefono.string'=> 'Il campo telefono non accetta cartatteri speciali',
            'email.required'=> 'Inserire un contatto email',
            'indirizzo.required'=> 'Inserire l\'indirizzo di residenza',
            'indicizzo.string'=> 'Il campo indirizzo non accetta cartatteri speciali',
            'citta.required'=> 'Inserire la città di residenza',
            'ciita.string'=> 'Il campo città non accetta cartatteri speciali',
            'provincia.required'=> 'Inserire la provincia di residenza',
            'provincia.string'=> 'Il campo provincia non accetta cartatteri speciali',
            'cap.required'=> 'Inserire il CAP di residenza',
            'cap.string'=> 'Il campo CAP non accetta cartatteri speciali',
            'data_nascita.required'=> 'Inserire la data di nascita',
        ]);
        if(!$validatedData->fails()){
            Associati::create([
                'id' => uniqid(),
                'nome' => $request['nome'],
                'cognome' => $request['cognome'],
                'codice_fiscale' => $request['codice_fiscale'],
                'nome_genitore' => $request['nome_genitore'],
                'cognome_genitore' => $request['cognome_genitore'],
                'telefono' => $request['telefono'],
                'email' => $request['email'],
                'indirizzo' => $request['indirizzo'],
                'citta' => $request['citta'],
                'provincia' => $request['provincia'],
                'cap' => $request['cap'],
                'data_nascita' => $request['data_nascita'],
                'iscritto' => 0,
            ]);
            return response()->json(['message' => 'associato aggiunto'], 200);
        }

        return response()->json(['message' => $validatedData->errors()], 200);
    }

    #[OA\Delete(
        path:'/api/elimina-associato/{id}',
        summary:'Elimina un associato tramite il suo id',
        tags: ["gestione associati"],
        parameters:[
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "id dell'associato da eliminare",
                schema: new OA\Schema(type: "string", minimum:16, description:"user id"),
            )],
        responses: [
            new OA\Response(response: 200, description: 'associato eliminato'),
            new OA\Response(response: 500, description: 'associato non trovato'),
        ]
    )]

    public function eliminaAssociato(Request $request){
        if(!empty($request['id'])){
            Associati::where('id', $request['id'])->delete();
            return response()->json(['message' => 'associato eliminato'], 200);
        }
        return response()->json(['message' => 'associato non trovato'], 500);
    }

    #[OA\Get(
        path:'/api/associato/{id}',
        summary:'Recupera un associato tramite il suo id',
        tags: ["gestione associati"],
        parameters:[
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "id dell'associato da recuperare",
                schema: new OA\Schema(type: "string", minimum:16, description:"user id"),
            )],
        responses: [
            new OA\Response(response: 200, description: 'dati dell\'associato'),
            new OA\Response(response: 500, description: 'associato non trovato'),
        ]
    )]

    public function ottieniAssociato(Request $request){
        if(!empty($request['id'])){
            $data = Associati::where('id', $request['id'])->get();
            return response()->json(['message' => $data], 200);
        }
        return response()->json(['message' => 'associato non trovato'], 500);
    }

   #[OA\Put(
        path: '/api/modifica-associato/{id}',
        summary: 'Modificata associato',
        tags: ["gestione associati"],
        description:"modifica i dati dell'associazione nel database",
        requestBody:new OA\RequestBody(
            required: true,
            description: 'dati associato',
            content: new OA\JsonContent(
                required: [
                    "id",
                    "nome",
                    "cognome",
                    "codice_fiscale",
                    "nome_genitore",
                    "cognome_genitore",
                    "telefono",
                    "email",
                    "indirizzo",
                    "citta",
                    "provincia",
                    "cap",
                    "data_nascita",
                    "iscritto",
                    "data_iscrizione",
                    "data_scadenza"
                ],
                properties: [
                    new OA\Property(property: "nome", type: "string", format: "text"),
                    new OA\Property(property: "cognome", type: "string", format: "text"),
                    new OA\Property(property: "codice_fiscale", type: "string", format: "text"),
                    new OA\Property(property: "nome_genitore", type: "string", format: "text"),
                    new OA\Property(property: "cognome_genitore", type: "string", format: "text"),
                    new OA\Property(property: "telefono", type: "string", format: "text"),
                    new OA\Property(property: "email", type: "string", format: "text"),
                    new OA\Property(property: "indirizzo", type: "string", format: "text"),
                    new OA\Property(property: "citta", type: "string", format: "text"),
                    new OA\Property(property: "provincia", type: "string", format: "text"),
                    new OA\Property(property: "cap", type: "string", format: "text"),
                    new OA\Property(property: "data_nascita", type: "string", format: "date"),
                    new OA\Property(property: "iscritto", type: "string", format: "boolean"),
                    new OA\Property(property: "data_iscrizione", type: "string", format: "date"),
                    new OA\Property(property: "data_scadenza", type: "string", format: "date")
                ]
            )
        ),
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "id dell'associato da recuperare",
                schema: new OA\Schema(type: "string", minimum: 16, description: "user id"),
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'associato aggiunto'),
            new OA\Response(response: 500, description: 'Errore nell\'inserimento del nuovo associato'),
        ]
    )]

    public function modificaAssociato(Request $request){
        log::info($request['id']);
        if (!empty($request['id'])) {
                try{
                $validatedData = Validator::make($request->all(),[
                    'nome' => 'required|string|max:255',
                    'cognome' => 'required|string|max:255',
                    'codice_fiscale' => 'required|string|max:16',
                    'nome_genitore' => 'required|string|max:255',
                    'cognome_genitore' => 'required|string|max:255',
                    'telefono' => 'required|string|max:255',
                    'email' => 'required|email',
                    'indirizzo' => 'required|string|max:255',
                    'citta' => 'required|string|max:255',
                    'provincia' => 'required|string|max:255',
                    'cap' => 'required|string|max:5',
                    'data_nascita'=> 'required|date',
                    'iscritto' => 'required|boolean',
                    'data_iscrizione' => 'required|date',
                    'data_scadenza' => 'required|date',
                ],[
                    'nome.required' => 'Inserire un nome',
                    'nome.string' => 'Il campo nome non accetta cartatteri speciali',
                    'cognome.required' => 'Inserire un cognome',
                    'cognome.string' => 'Il campo cognome non accetta cartatteri speciali',
                    'codice_fiscale.required' => 'Inserire il codice fiscale dell\'associato',
                    'codice_fiscale.string' => 'Il campo codice fiscale non accetta cartatteri speciali',
                    'nome_genitore.required'=> 'Inserire il nome del genitore di riferimento',
                    'nome_genitore.string'=> 'Il campo nome genitore non accetta cartatteri speciali',
                    'cognome_genitore'=> 'Inserire il cognome del genitore di riferimento',
                    'cognome_genitore.string'=> 'Il campo cognome genitore non accetta cartatteri speciali',
                    'telefono.required'=> 'Inserire un contatto telefonico',
                    'telefono.string'=> 'Il campo telefono non accetta cartatteri speciali',
                    'email.required'=> 'Inserire un contatto email',
                    'indirizzo.required'=> 'Inserire l\'indirizzo di residenza'
                ]);
                log::info($validatedData->fails());
                if (!$validatedData->fails()) {
                    $data = Associati::where('id', $request['id'])->get();
                    Associati::where('id', $request['id'])->update([
                        'nome' => $request['nome'],
                        'cognome' => $request['cognome'],
                        'codice_fiscale' => $request['codice_fiscale'],
                        'nome_genitore' => $request['nome_genitore'],
                        'cognome_genitore' => $request['cognome_genitore'],
                        'telefono' => $request['telefono'],
                        'email' => $request['email'],
                        'indirizzo' => $request['indirizzo'],
                        'citta' => $request['citta'],
                        'provincia' => $request['provincia'],
                        'cap' => $request['cap'],
                        'data_nascita' => $request['data_nascita'],
                        'iscritto' => $request['iscritto'],
                        'data_iscrizione' => $request['data_iscrizione'],
                        'data_scadenza' => $request['data_scadenza'],
                    ]);
                    return response()->json(['message' => $data], 200);
                }
                return response()->json(['message'=> $validatedData->errors()],500);
            }
            catch(\Exception $e){
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
        return response()->json(['message'=> 'account non trovato'],404);
    }
}
