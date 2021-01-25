<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Status;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        $posts = Post::currentStatus(Status::PUBLISHED)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate();

        return Inertia::render('Posts/Index', [
            'posts' => PostResource::collection($posts)
        ]);
    }

    public function show(Post $post): Response
    {
        return Inertia::render('Posts/Show', [
            'post' => new PostResource($post),
        ]);
    }
}
