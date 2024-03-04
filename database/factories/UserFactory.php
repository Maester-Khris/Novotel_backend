<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
   
    public function definition()
    {
        $password = ["pass"];
        return [
            'uuid' => Str::random(5),
            'full_name' => $this->faker->name(),
            'telephone' => '+237 6'.$this->faker->randomNumber(8),
            'password' => $this->faker->randomElement($password), // password
            'remember_token' => Str::random(10),
            'is_manager' => $this->faker->boolean,
            'is_receptionist' => $this->faker->boolean,
            'created_at' => Carbon::parse($this->faker->dateTimeBetween('-2 year', 'now'))->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
