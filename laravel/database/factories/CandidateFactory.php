<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'education_institution_id' => \App\Models\EducationInstitution::inRandomOrder()->first()->id,
            'birthday' => $this->faker->date,
            'experience' => $this->faker->randomDigitNotNull(),
            'last_position_id' => \App\Models\Position::inRandomOrder()->first()->id,
            'applied_position_id' => \App\Models\Position::inRandomOrder()->first()->id,
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'resume' => '',
        ];
    }
}
