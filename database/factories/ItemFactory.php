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
      'description' => $this->faker->text(),
      'img' => fake()->randomElement([
        'https://picsum.photos/200/300?random=1',
        'https://picsum.photos/200/300?random=2',
        'https://picsum.photos/200/300?random=3',
      ]),
      'is_active' => $this->faker->boolean(),
    ];
  }
}
