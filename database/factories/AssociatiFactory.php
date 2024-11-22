<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Associati;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Associati>
 */
class AssociatiFactory extends Factory
{
    protected $model = Associati::class;

    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'nome' => $this->faker->firstName,
            'cognome' => $this->faker->lastName,
            'codice_fiscale' => $this->faker->unique()->bothify('??????##?##?###?'),
            'nome_genitore' => $this->faker->firstName,
            'cognome_genitore' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'indirizzo' => $this->faker->address,
            'citta' => $this->faker->city,
            'provincia' => $this->faker->state,
            'cap' => $this->faker->postcode,
            'data_nascita' => $this->faker->date,
            'iscritto' => 0,
        ];
    }
}
