<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectDocumentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(),
            'category' => $this->faker->randomElement(['Kontrak & Legal', 'SOP', 'Manual', 'Drawing', 'Laporan']),
            'title' => $this->faker->numerify('##-####') . ' ' . $this->faker->words(3, true),
            'file_type' => $this->faker->randomElement(['PDF', 'XLS', 'DOCX', 'DWG']),
            'file_size' => $this->faker->numberBetween(100, 999) . ' KB',
        ];
    }
}
