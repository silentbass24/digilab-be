<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Users;
use App\Models\Corsi;
use App\Models\Associati;
use App\Models\IscrizioneCorsi;

class IscrizioniTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    use RefreshDatabase;
    public function testCreaIscrizione()
    {
        // Crea un utente di esempio
        $user = Users::factory()->create();

        // Autentica l'utente e ottieni un token
        $token = $user->createToken('TestToken')->plainTextToken;

        // Crea un corso di esempio
        $corso = Corsi::factory()->create();

        // Crea un associato di esempio
        $associato = Associati::factory()->create();

        // Dati di esempio per la richiesta
        $data = [
            'id'=> uniqid(),
            'corso_id' => $corso->id,
            'associato_id' => $associato->id,
            'data_iscrizione' => '2024-12-01',
            'pagato' => true,
        ];

        // Effettua una richiesta POST all'endpoint
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/nuova-iscrizione', $data);

        // Verifica che la risposta abbia un codice di stato 200
        $response->assertStatus(200);

        // Verifica che il record sia stato creato nel database
        $this->assertDatabaseHas('iscrizione_corsi', [
            'corso_id' => $corso->id,
            'associato_id' => $associato->id,
            'data_iscrizione' => '2024-12-01',
            'pagato' => true,
        ]);
    }

    public function testEliminaIscrizione()
    {
        // Crea un utente di esempio
        $user = Users::factory()->create();

        // Autentica l'utente e ottieni un token
        $token = $user->createToken('TestToken')->plainTextToken;

        // Crea un corso di esempio
        $corso = Corsi::factory()->create();

        // Crea un associato di esempio
        $associato = Associati::factory()->create();

        // Crea un'iscrizione di esempio
        $iscrizione = IscrizioneCorsi::factory()->create([
            'id' => uniqid(),
            'corso_id' => $corso->id,
            'associato_id' => $associato->id,
            'data_iscrizione' => '2024-12-01',
            'pagato' => true,
        ]);

        // Effettua una richiesta DELETE all'endpoint
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/elimina-iscrizione/'. $associato->id);
        dd($response->getContent());
        // Verifica che la risposta abbia un codice di stato 200
        $response->assertStatus(200);

        // Verifica che il record sia stato eliminato dal database
        $this->assertDatabaseMissing('iscrizione_corsi', [
            'corso_id' => $corso->id,
            'associato_id' => $associato->id,
            'data_iscrizione' => '2024-12-01',
            'pagato' => true,
        ]);
    }

    /**
     * Test per il metodo eliminaIscrizione quando l'iscrizione non esiste.
     *
     * @return void
     */
    public function testEliminaIscrizioneNonTrovata()
    {
        // Crea un utente di esempio
        $user = Users::factory()->create();

        // Autentica l'utente e ottieni un token
        $token = $user->createToken('TestToken')->plainTextToken;

        // Effettua una richiesta DELETE all'endpoint con un ID non esistente
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/elimina-iscrizione/637483874');

        // Verifica che la risposta abbia un codice di stato 404
        $response->assertStatus(404);

        // Verifica che la risposta contenga il messaggio di errore
        $response->assertJson([
            'message' => 'iscrizione non trovata'
        ]);
    }
}
