<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ImageFactory extends Factory
{

    public function definition()
    {
        $name = $this->faker->bothify('modifed#?##??#.webp');
        $original_name = $this->faker->bothify('??#?###?#?#.jpg');
        return [
            'name' => $name,
            'path' => '/new-path/' . $name,
            'original_name' => $original_name,
            'original_path' => '/old-path/' . $original_name,
        ];
    }
}
