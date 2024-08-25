<?php

namespace Database\Factories;

use App\Models\Condicion;
use Illuminate\Database\Eloquent\Factories\Factory;
 
class CondicionFactory extends Factory
{
    protected $model = Condicion::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombreCondicion' => $this->faker->word,  
        ];
    }
}
