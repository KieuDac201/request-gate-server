<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text($maxNbChars = 100),
            'content' => $this->faker->text($maxNbChars = 200),
            'status' => $this->faker->randomElement($array = array ('1','2','3')),
            'author_id' => random_int(2, 10),
            'due_date' => now(),
            'category_id' => random_int(1, 10),
            'priority' => $this->faker->randomElement($array = array ('0','1')),
            'person_in_charge' => random_int(1, 10),
        ];
    }
}
