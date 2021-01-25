<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Status;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPostControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()
            ->hasAttached(
                Team::factory()
                    ->state(function (array $attributes, User $user) {
                        return ['user_id' => $user->id, 'personal_team' => true];
                    }),
            )
            ->create();

        Storage::fake();
    }

    public function test_can_view_posts()
    {
        Post::factory(5)->create();

        $this->actingAs($this->user)
            ->get('/admin/posts')
            ->assertStatus(200)
            ->assertPropCount('posts.data', 5)
            ->assertPropValue('posts.data', function ($posts) {
                $this->assertEmpty(
                    array_diff(
                        array_keys($posts[0]),
                        ['id', 'created_at', 'updated_at', 'title', 'slug', 'content', 'excerpt', 'author_id', 'author', 'thumbnail', 'status']
                    )
                );
            });
    }

    public function test_can_search_for_posts()
    {
        $this->user->posts()->saveMany(
            Post::factory(5)->make()
        )->first()->update(['title' => 'Some Big Fancy Company Name']);

        $this->actingAs($this->user)
            ->get('/admin/posts?search=Some Big Fancy Company Name')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Some Big Fancy Company Name')
            ->assertPropCount('posts.data', 1)
            ->assertPropValue('posts.data', function ($posts) {
                $this->assertEquals('Some Big Fancy Company Name', $posts[0]['title']);
            });
    }

    public function test_can_paginate_posts()
    {
        Post::factory(12)->create();

        $this->actingAs($this->user)
            ->get('/admin/posts?page=2')
            ->assertStatus(200)
            ->assertPropCount('posts.data', 2);
    }

    public function test_can_store_post()
    {
        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');

        $this->actingAs($this->user)
            ->post('/admin/posts', [
                'title' => 'My title',
                'content' => 'My content',
                'thumbnail' => $thumbnail,
            ])
            ->assertRedirect('/admin/posts');

        $this->assertDatabaseHas('posts', ['title' => 'My title']);
        $this->assertDatabaseHas('media', ['file_name' => 'thumbnail.jpg']);
    }

    public function test_can_update_post()
    {
        $post = Post::factory()->withThumbnail()->create();

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');

        $this->actingAs($this->user)
            ->put("/admin/posts/{$post->id}", [
                'title' => 'My Title updated',
                'content' => 'My content updated',
                'thumbnail' => $thumbnail,
            ])
            ->assertRedirect('/admin/posts');

        $post->refresh();

        $this->assertEquals('My content updated', $post->content);
        $this->assertEquals('My Title updated', $post->title);
        $this->assertEquals('thumbnail.jpg', $post->getFirstMedia('thumbnail')['file_name']);
    }

    public function test_can_delete_post()
    {
        $post = Post::factory()->create();

        $this->actingAs($this->user)
            ->delete("/admin/posts/{$post->id}")
            ->assertRedirect('/admin/posts');

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_remove_thumbnail()
    {
        $post = Post::factory()->withThumbnail()->create();

        $this->actingAs($this->user)
            ->deleteJson("/admin/posts/{$post->id}/thumbnail")
            ->assertSuccessful();

        $post->refresh();

        $this->assertEmpty($post->thumbnail_url);
    }

    public function test_publish_post()
    {
        $post = Post::factory()
            ->has(Status::factory(['name' => Status::DRAFT])->count(1))
            ->create();

        $this->actingAs($this->user)
            ->post(route('admin.posts.publish', $post->id))
            ->assertRedirect(route('admin.posts.edit', $post->id));

        $post->refresh();

        $this->assertEquals(Status::PUBLISHED, $post->status);
    }
}
