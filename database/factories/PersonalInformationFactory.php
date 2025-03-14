<?php

namespace Database\Factories;

use App\Models\PersonalInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalInformationFactory extends Factory
{
    protected $model = PersonalInformation::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'profile_title' => $this->faker->jobTitle,
            'about_me' => $this->faker->paragraph,
        ];
    }
}