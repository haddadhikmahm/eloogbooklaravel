<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectMemberFactory extends Factory
{
    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        
        return [
            'project_id' => \App\Models\Project::factory(),
            'name' => $firstName . ' ' . $lastName,
            'email' => strtolower($firstName) . '@bita.com',
            'initials' => strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1)),
            'color_hex' => $this->faker->hexColor(),
            'discipline' => $this->faker->randomElement(['Architectural', 'Electrical', 'Mechanical', 'Civil', 'Structural', 'Quantity Surveyor & Estimating', 'Project Control']),
            'role' => $this->faker->randomElement(['Project Manager', 'Senior Leader', 'Engineer', 'Drafter']),
            'access_level' => $this->faker->randomElement(['Full Access', 'Edit & Upload', 'View Only']),
            'active_documents' => $this->faker->numberBetween(10, 100),
        ];
    }
}
