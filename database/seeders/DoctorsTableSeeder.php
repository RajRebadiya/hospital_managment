<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;  // Ensure the namespace is correct

class DoctorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Doctor::factory(10)->create();
    }
}
