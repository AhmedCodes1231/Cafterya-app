<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CafeteriaInfo>
 */
class CafeteriaInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'phone' => $this->faker->phoneNumber(),
            //'phone2' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
        ];
    }
}


/*
$user = new \App\Models\User();
$user->name = "Admin";
$user->email = "admin@example.com";
$user->username = "admin"; // أضف هذا السطر
$user->password = bcrypt("123");
$user->save();


$role = \App\Models\Role::where("name", "manager")->first();
$user->roles()->attach($role->id);
*/
