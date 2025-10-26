<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'name' => $this->faker->name(),
      'category_id' => $this->faker->numberBetween(1, 2),
      'price' => $this->faker->randomFloat(2, 1000, 100000),
      'descripotion' => $this->faker->text(),
      'img' => $this->faker->imageUrl(),
      'is_active' => $this->faker->boolean(),
    ];
  }
}
