<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'request_id' => random_int(1, 10),
            'user_id' => random_int(1, 10),
            'content' => $this->faker->text($maxNbChars = 200),
        ];
    }
}
