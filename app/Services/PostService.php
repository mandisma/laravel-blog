<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class PostService implements PostServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(array $attributes): Post
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        $post = $user->posts()->create($attributes);

        if (!is_null($attributes['thumbnail'])) {
            $post->setThumbnail($attributes['thumbnail']);
        }

        $post->setStatus(Status::DRAFT);

        return $post;
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $attributes): Post
    {
        $post = Post::find($id);
        $post->update($attributes);

        if (!is_null($attributes['thumbnail'])) {
            $post->setThumbnail($attributes['thumbnail']);
        }

        return $post;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): void
    {
        Post::find($id)->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function publish(int $id): void
    {
        Post::find($id)->setStatus(Status::PUBLISHED);
    }
}
