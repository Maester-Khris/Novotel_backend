<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
   

    public function definition()
    {
        $location_id = array();
        $country_id = array();
        for ($i = 1; $i <= 100; $i++) {
            $country_id[] = $i;
            $location_id[] = $i;
        }


        return [
            'uuid' => Str::random(5),
            'full_name' => $this->faker->name(),
            'birth_date' => $this->faker->date(),
            'telephone' => '+237 6'.$this->faker->randomNumber(8),
            'nationality_country_id' => $this->faker->randomElement($country_id),
            'living_country_id' => $this->faker->randomElement($country_id),
            'address_location_id' => $this->faker->randomElement($location_id),
            'nic_card_id' => '182'.Str::random(10),
            'nic_card_delivery' => $this->faker->date(),
            'created_at' => Carbon::parse($this->faker->dateTimeBetween('-1 year', 'now'))->format('Y-m-d H:i:s')
        ];
    }
}
