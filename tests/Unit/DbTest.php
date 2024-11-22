<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class DbTest extends TestCase
{
    /**
     * Test per verificare la connessione al database.
     *
     * @return void
     */
    public function testDatabaseConnection()
    {
        try {
            // Esegui una semplice query sul database
            $result = DB::select('SELECT 1');

            // Verifica che la query abbia restituito un risultato
            $this->assertNotEmpty($result, 'La connessione al database non è riuscita.');
        } catch (\Exception $e) {
            // Se c'è un'eccezione, fallisci il test
            $this->fail('La connessione al database non è riuscita: ' . $e->getMessage());
        }
    }
}
