<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Corsi;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Corsi>
 */
class CorsiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Corsi::class;

    public function definition(): array
    {
        return [
           'id' => $this->faker->uuid(),
            'titolo' => $this->faker->sentence(),
            'descrizione' => $this->faker->paragraph(),
            'data_inizio' => $this->faker->date('Y-m-d', '+1 month'),
            'data_fine' => $this->faker->date('Y-m-d', '+2 months'),
            'costo' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
