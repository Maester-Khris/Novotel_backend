<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    

    public function definition()
    {
        $resource_type = array('Appartement','Chambre','Lit');
        $resourceid = array();
        for ($i = 1; $i <= 100; $i++) {
            $resourceid[] = $i;
        }


        return [
            'uuid' => Str::random(5),
            'resource_name' => $this->faker->randomElement($resource_type).' '.$this->faker->randomElement($resourceid),
            'resource_availability' => true,
            'is_room' => $this->faker->boolean,
            'is_appartment' => $this->faker->boolean,
            'is_bed' => $this->faker->boolean,
            'created_at' => $this->faker->dateTime()
        ];
    }
}
