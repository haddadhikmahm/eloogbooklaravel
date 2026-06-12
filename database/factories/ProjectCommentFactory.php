<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectCommentFactory extends Factory
{
    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        return [
            'project_id' => \App\Models\Project::factory(),
            'document_code' => $this->faker->numerify('####-DRW-###'),
            'text' => $this->faker->sentence(10),
            'author_name' => $firstName . ' ' . substr($this->faker->lastName(), 0, 1) . '.',
            'author_initials' => strtoupper(substr($firstName, 0, 2)),
            'status' => $this->faker->randomElement(['OPEN', 'CLOSE']),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }
}
