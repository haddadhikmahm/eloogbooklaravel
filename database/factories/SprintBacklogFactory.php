<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SprintBacklogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(),
            'drawings_title' => $this->faker->numerify('####') . '-DRW-' . strtoupper($this->faker->bothify('???-###')) . '-' . strtoupper($this->faker->words(2, true)),
            'discipline' => $this->faker->randomElement(['Arsitektur', 'Elektrikal', 'Mekanikal', 'Sipil', 'Struktur']),
            'personnel_name' => $this->faker->firstName(),
            'amount' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement(['To Do', 'Progress', 'Review', 'Done']),
        ];
    }
}
