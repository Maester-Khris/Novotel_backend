<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    

    public function definition()
    {
        $names = ['Haven Hospitality','Elite Escapes','Oasis Properties','Luxe Lodgings','Serene Stays','Regal Residences','Tranquil Travelers',
        'Grand Getaways','Premier Properties','Serendipity Stays','Exquisite Escapes','Majestic Mansions','Opulent Oasis','Sumptuous Suites','Blissful Beds'];
        $location_id = array();
        $stars = [1,2,3,4,5];
        for ($i = 1; $i <= 100; $i++) {
            $location_id[] = $i;
        }


        return [
            'uuid' => Str::random(5),
            'comp_name' => $this->faker->unique()->randomElement($names),
            'comp_telephone' => '+237 6'.$this->faker->randomNumber(8),
            'comp_location_id' => $this->faker->randomElement($location_id),
            'comp_mail_address' => $this->faker->unique()->safeEmail(),
            'comp_web_site' => 'www'.Str::random(6).'.docs.cmr',
            'comp_standing_stars' => $this->faker->randomElement($stars),
            'created_at' => $this->faker->dateTimeBetween('-2 year', 'now')
        ];
    }
}
