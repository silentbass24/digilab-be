<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Corsi;
use App\Models\Users;



class CorsiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test per il metodo getAllAssociati.
     *
     * @return void
     */
    public function testGetAllCorsi()
    {
        // Crea alcuni record di esempio nel database
        Corsi::factory()->count(3)->create();

        // Effettua una richiesta GET all'endpoint
        $response = $this->get('/api/lista-corsi');

        // Verifica che la risposta abbia un codice di stato 200
        $response->assertStatus(200);

        // Verifica che la risposta contenga i dati degli associati
        $response->assertJsonStructure([
            'message' => [
                '*' => [
                    'id',
                    'titolo',
                    'descrizione',
                    'data_inizio',
                    'data_fine',
                    'costo',
                ]
            ]
        ]);
    }

    public function testAddNuovoCorso()
    {
        $user = Users::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        // Dati di esempio per la richiesta
        $data = [
            'titolo' => 'Corso di prova',
            'descrizione' => 'descrizione del corso di prova',
            'data_inizio' => '2024-12-01',
            'data_fine' => '2024-12-01',
            'costo' => '200',
        ];

        // Effettua una richiesta POST all'endpoint
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('api/nuovo-corso', $data);

        // Verifica che la risposta abbia un codice di stato 200
        $response->assertStatus(200);

        // Verifica che il record sia stato creato nel database
        $this->assertDatabaseHas('corsi', [
            'titolo' => 'Corso di prova',
            'descrizione' => 'descrizione del corso di prova',
            'data_inizio' => '2024-12-01',
            'data_fine'=> '2024-12-01',
            'costo' => '200',
        ]);
    }

    public function testUpdateCorso()
    {
        $user = Users::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $corso = Corsi::factory()->create([
            'id' => uniqid(),
            'titolo' => 'Corso di prova',
            'descrizione' => 'descrizione del corso di prova',
            'data_inizio' => '2024-12-01',
            'data_fine' => '2024-12-01',
            'costo' => '200',
        ]);

        $data = [
            'titolo' => 'Corso di prova',
            'descrizione' => 'descrizione del carso di prova',
            'data_inizio' => '2024-12-01',
            'data_fine' => '2024-12-01',
            'costo' => '400',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put("api/modifica-corso/" . $corso->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('corsi', [
            'id' => $corso->id,
            'titolo' => 'Corso di prova',
            'descrizione' => 'descrizione del carso di prova',
            'data_inizio' => '2024-12-01',
            'data_fine' => '2024-12-01',
            'costo' => '400',
        ]);

    }

    public function testOttieniCorso()
    {
        $user = Users::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $corso = Corsi::factory()->create([
            'id' => uniqid(),
            'titolo' => 'Corso di prova',
            'descrizione' => 'descrizione del corso di prova',
            'data_inizio' => '2024-12-01',
            'data_fine' => '2024-12-01',
            'costo' => '200',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("api/corso/" . $corso->id);
        $response->assertStatus(200);
        $this->assertDatabaseHas('corsi', [
            'id' => $corso->id,
            'titolo' => 'Corso di prova',
            'descrizione' => 'descrizione del corso di prova',
            'data_inizio' => '2024-12-01',
            'data_fine' => '2024-12-01',
            'costo' => '200',
        ]);
    }

    public function testEliminaCorso()
    {
        $user = Users::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $corso = Corsi::factory()->create([
            'id' => uniqid(),
            'titolo' => 'Corso di prova',
            'descrizione' => 'descrizione del corso di prova',
            'data_inizio' => '2024-12-01',
            'data_fine' => '2024-12-01',
            'costo' => '200',
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete("api/elimina-corso/" . $corso->id);
        $response->assertStatus(200);
    }
}
