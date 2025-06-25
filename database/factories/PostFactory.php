<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $path = Storage::disk('public')->files('posts');
        $photo = $path[array_rand($path)];

        return [
            'body' => fake()->text(),
            'photo' => config('app.url') . '/file' . '/' . $photo,
            'user_id' => User::factory()->create(),
        ];
    }
}
