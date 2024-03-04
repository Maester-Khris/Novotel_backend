<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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
            'resource_name' => $this->faker->randomElement($resource_type).' No '.$this->faker->randomElement($resourceid),
            'resource_availability' => true,
            'is_room' => $this->faker->boolean,
            'is_appartment' => $this->faker->boolean,
            'is_bed' => $this->faker->boolean,
            'created_at' => Carbon::parse($this->faker->dateTimeBetween('-2 year', 'now'))->format('Y-m-d H:i:s')
        ];
    }
}
