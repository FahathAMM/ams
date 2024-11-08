<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
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
            'title' => fake()->title(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'username' => fake()->name(),
            'designation' => fake()->jobTitle(),
            'contact' => fake()->phoneNumber(),
            'img' => fake()->imageUrl(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' =>  $this->customEncrypt('password'),
            'remember_token' => Str::random(10),
            'role_id' => 1,
            'is_active' => $this->faker->boolean,
        ];

        // 'title' => 'Ms.',
        // 'first_name' => 'Jane Doe',
        // 'username' => 'jane',
        // 'email' => 'janedoe@example.com',
        // 'email_verified_at' => now(),
        // 'password' => $this->customEncrypt('password123'),
        // 'contact' => '0987654321',
        // 'branch' => 'Los Angeles',
        // 'img' => 'jane_doe_profile.jpg',
        // 'is_active' => 1,
        // 'remember_token' => Str::random(10),
        // 'created_at' => now(),
        // 'updated_at' => now(),
        // 'role_id' => 2,

    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    private function customEncrypt($pass)
    {
        $str = $pass;
        $key = '4QcTlzuaNUcX289Z9D0ovPCzb';
        $iv = "1234567812345678";
        $encryption_key = base64_encode($key);
        $encrypted = openssl_encrypt($str, 'aes-256-cbc', $encryption_key, true, $iv);
        $encrypted_data = base64_encode($encrypted);
        return ($encrypted_data);
    }
}
