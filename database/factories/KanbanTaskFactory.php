<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KanbanTaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(),
            'title' => 'Revisi ' . $this->faker->words(3, true),
            'status' => $this->faker->randomElement(['To Do', 'In Progress', 'Review', 'Done', 'Waiting Client']),
        ];
    }
}
