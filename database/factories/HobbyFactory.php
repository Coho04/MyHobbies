<?php

namespace Database\Factories;

use App\Models\Hobby;
use Illuminate\Database\Eloquent\Factories\Factory;

class HobbyFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Hobby::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->realText(30),
            'beschreibung'=> $this->faker->realText(),
        ];
    }
}
