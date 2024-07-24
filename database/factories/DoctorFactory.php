<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\Doctor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Doctor::class;
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->name(),
            'specialization' => $this->faker->randomElement(['Cardiologist', 'Dermatologist', 'nephrologist']),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'password' => $this->faker->password(8, 10),
            'created_at' => now(),
            'updated_at' => now(),


        ];
    }
}
