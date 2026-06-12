<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientRevisionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'document_name' => $this->faker->numerify('####') . '-DRW-' . $this->faker->words(3, true),
            'revision_code' => $this->faker->randomElement(['A', 'B', 'C', '0', '1', '2']),
            'description' => $this->faker->sentence(10),
            'personnel_name' => $this->faker->firstName(),
            'status' => $this->faker->randomElement(['Open', 'Close']),
        ];
    }
}
