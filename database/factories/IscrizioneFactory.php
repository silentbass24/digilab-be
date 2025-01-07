<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\IscrizioneCorsi;
use App\Models\Corsi;
use App\Models\Associati;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IscrizioneCorsi>
 */
class IscrizioneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = IscrizioneCorsi::class;
    public function definition(): array
    {
            return [
            'id' => $this->faker->uuid(),
            'associato_id' => Associati::factory(),
            'corso_id' => Corsi::factory(),
            'data_iscrizione' => $this->faker->date('Y-m-d'),
            'pagato' => $this->faker->boolean(),
        ];
    }
}
