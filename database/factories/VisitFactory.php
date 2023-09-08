<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    
    public function definition()
    {
        $world_place = [
            'Emerald Bay, California, USA',
            'Lavender Fields, Provence-Alpes-Côte d\'Azur, France',
            'Golden Gate Park, California, USA',
            'Blue Lagoon, Reykjavik, Iceland',
            'Red Rock Canyon, Nevada, USA',
            'Great Barrier Reef, Queensland, Australia',
            'Niagara Falls, Ontario, Canada',
            'Grand Canyon National Park, Arizona, USA',
            'Scottish Highlands, Scotland, UK',
            'Yosemite National Park, California, USA',
            'Andalusian Coast, Andalusia, Spain',
            'Banff National Park, Alberta, Canada',
            'Rocky Mountains, Colorado, USA',
            'Lake District National Park, Cumbria, UK',
            'Swiss Alps, Switzerland'
        ];

        return [
            'uuid' => Str::random(5),
            'visit_start_date' => $this->faker->date(),
            'visit_end_date' => $this->faker->date(),
            'client_coming_from' =>$this->faker->randomElement($world_place),
            'client_going_to' =>$this->faker->randomElement($world_place),
            'created_at' => $this->faker->dateTime()
        ];
    }
}
