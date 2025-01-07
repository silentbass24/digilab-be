<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Associati;
use App\Models\Users;

class AssociatoControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test per il metodo getAllAssociati.
     *
     * @return void
     */
    public function testGetAllAssociati()
    {
        $user = Users::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        // Crea alcuni record di esempio nel database
        Associati::factory()->count(3)->create();

        // Effettua una richiesta GET all'endpoint
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/associati');


        // Verifica che la risposta abbia un codice di stato 200
        $response->assertStatus(200);

        // Verifica che la risposta contenga i dati degli associati
        $response->assertJsonStructure([
            'message' => [
                '*' => [
                    'id',
                    'nome',
                    'cognome',
                    'codice_fiscale',
                    'nome_genitore',
                    'cognome_genitore',
                    'telefono',
                    'email',
                    'indirizzo',
                    'citta',
                    'provincia',
                    'cap',
                    'data_nascita',
                    'iscritto',
                    'data_iscrizione',
                    'data_scadenza',
                ]
            ]
        ]);
    }

    public function testAddNuovoAssociato()
    {
        // Dati di esempio per la richiesta
        $data = [
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'codice_fiscale' => 'RSSMRA80A01H501Z',
            'nome_genitore' => 'Luigi',
            'cognome_genitore' => 'Rossi',
            'telefono' => '1234567890',
            'email' => 'mario.rossi@example.com',
            'indirizzo' => 'Via Roma 1',
            'citta' => 'Roma',
            'provincia' => 'RM',
            'cap' => '00100',
            'data_nascita' => '1980-01-01'
        ];

        // Effettua una richiesta POST all'endpoint
        $response = $this->post('api/nuovo-associato', $data);

        // Verifica che la risposta abbia un codice di stato 200
        $response->assertStatus(200);

        // Verifica che il record sia stato creato nel database
        $this->assertDatabaseHas('associati', [
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'codice_fiscale' => 'RSSMRA80A01H501Z',
            'email' => 'mario.rossi@example.com'
        ]);
    }

    public function testUpdateAssociato(){
        $user = Users::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $associato = Associati::factory()->create([
            'id' => uniqid(),
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'codice_fiscale' => 'RSSMRA80A01H501Z',
            'nome_genitore' => 'Luigi',
            'cognome_genitore' => 'Rossi',
            'telefono' => '1234567890',
            'email' => 'mario.rossi@example.com',
            'indirizzo' => 'Via Roma 1',
            'citta' => 'Roma',
            'provincia' => 'RM',
            'cap' => '00100',
            'data_nascita' => '1980-01-01',
            'iscritto' => 0,
        ]);

        $data =[
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'codice_fiscale' => 'RSSMRA80A01H501Z',
            'nome_genitore' => 'Luigi',
            'cognome_genitore' => 'Rossi',
            'telefono' => '1234567890',
            'email' => 'mario.rossi@example.com',
            'indirizzo' => 'Via Roma 1',
            'citta' => 'Roma',
            'provincia' => 'RM',
            'cap' => '00100',
            'data_nascita' => '1980-01-01',
            'iscritto' => 1,
            'data_iscrizione' => date('Y-m-d'),
            'data_scadenza' => date('Y-m-d', strtotime('+1 year'))
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put("api/modifica-associato/" . $associato->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('associati', [
            'id'=> $associato->id,
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'codice_fiscale' => 'RSSMRA80A01H501Z',
            'email' => 'mario.rossi@example.com',
            'iscritto' => 1,
            'data_iscrizione' => date('Y-m-d'),
            'data_scadenza' => date('Y-m-d', strtotime('+1 year'))
        ]);

    }

    public function testOttieniAssociato(){
        $user = Users::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $associato = Associati::factory()->create([
            'id' => uniqid(),
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'codice_fiscale' => 'RSSMRA80A01H501K',
            'nome_genitore' => 'Luigi',
            'cognome_genitore' => 'Rossi',
            'telefono' => '1234567890',
            'email' => 'mario.rossi@example.com',
            'indirizzo' => 'Via Roma 1',
            'citta' => 'Roma',
            'provincia' => 'RM',
            'cap' => '00100',
            'data_nascita' => '1980-01-01',
            'iscritto' => 0,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("api/associato/" . $associato->id);

        $response->assertStatus(200);
        $this->assertDatabaseHas('associati', [
            'id' => $associato->id,
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'codice_fiscale' => 'RSSMRA80A01H501K',
            'nome_genitore' => 'Luigi',
            'cognome_genitore' => 'Rossi',
            'telefono' => '1234567890',
            'email' => 'mario.rossi@example.com',
            'indirizzo' => 'Via Roma 1',
            'citta' => 'Roma',
            'provincia' => 'RM',
            'cap' => '00100',
            'data_nascita' => '1980-01-01',
            'iscritto' => 0,
        ]);
    }

    public function testEliminaAssociato(){
        $user = Users::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $associato = Associati::factory()->create([
            'id' => uniqid(),
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'codice_fiscale' => 'RSSMRA80A01H501K',
            'nome_genitore' => 'Luigi',
            'cognome_genitore' => 'Rossi',
            'telefono' => '1234567890',
            'email' => 'mario.rossi@example.com',
            'indirizzo' => 'Via Roma 1',
            'citta' => 'Roma',
            'provincia' => 'RM',
            'cap' => '00100',
            'data_nascita' => '1980-01-01',
            'iscritto' => 0,
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete("api/elimina-associato/" . $associato->id);
        $response->assertStatus(200);
    }
}
