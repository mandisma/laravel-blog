<?php

namespace App\Services;

use App\Models\Post;

interface PostServiceInterface
{
    public function create(array $attributes): Post;
    public function update(int $id, array $attributes): Post;
    public function delete(int $id): void;
    public function publish(int $id): void;
}
