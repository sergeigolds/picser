<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ImageFactory extends Factory
{

    public function definition()
    {
        $id = $this->faker->uuid();
        $name = $this->faker->bothify('modifed#?##??#.webp');
        $original_name = $this->faker->bothify('??#?###?#?#.jpg');
        return [
            'uuid' => $id,
            'path' => '/new-path/' . $id . '.webp',
        ];
    }
}
