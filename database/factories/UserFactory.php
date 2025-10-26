<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserFactory extends Factory
{
  protected static ?string $password;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'username' => fake()->unique()->userName(),
      'password' => static::$password ??= Hash::make('password'),
      'fullname' => fake()->name(),
      'email' => fake()->unique()->safeEmail(),
      'phone' => fake()->phoneNumber(),
      'role_id' => fake()->numberBetween(1, 3),
    ];
  }

  public function unverified(): static
  {
    return $this->state(fn(array $attributes) => [
      'email_verified_at' => null,
    ]);
  }
}
