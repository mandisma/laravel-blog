<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph(15),
            'author_id' => User::factory(),
        ];
    }

    /**
     * Get a fake image url.
     *
     * @return string
     */
    public function getThumbnailUrl(): string
    {
        return $this->faker->imageUrl(1920, 1080);
    }

    /**
     * Add a thumbnail to the post after the creation.
     *
     * @return self
     */
    public function withThumbnail(): self
    {
        return $this->afterCreating(function ($post) {
            // TODO: Use a media present in the storage for better performance.
            $post->addMediaFromUrl($this->getThumbnailUrl())->toMediaCollection('thumbnail');
        });
    }
}
