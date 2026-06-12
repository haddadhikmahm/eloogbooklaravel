<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => $this->faker->numerify('####'),
            'name' => $this->faker->randomElement([
                'DED Coal Terminal - Kalimantan Timur',
                'Feasibility Study Jembatan Suramadu',
                'Masterplan Kawasan Industri Batang',
                'EPC Pembangunan PLTU Jawa 7',
                'Desain Struktur Gedung Perkantoran Jakarta'
            ]),
            'type' => $this->faker->randomElement(['Detailed Engineering Design', 'Feasibility Study', 'EPC', 'Masterplan', 'Basic Engineering']),
            'disciplines_count' => $this->faker->numberBetween(3, 10),
            'personnel_count' => $this->faker->numberBetween(10, 50),
            'completion_percentage' => $this->faker->numberBetween(0, 100),
        ];
    }
}
