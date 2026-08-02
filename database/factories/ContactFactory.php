<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => 1,
            'email' => $this->faker->unique()->safeEmail(),
            'tel' => '09012345678',
            'address' => $this->faker->address(),
            'building' => 'テストビル',
            'detail' => 'テストお問い合わせ',
        ];
    }
}
