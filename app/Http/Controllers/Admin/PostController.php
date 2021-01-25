<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends AdminController
{
    /**
     * @var PostServiceInterface
     */
    protected $postService;

    /**
     * @param PostServiceInterface $postService
     */
    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    public function index(): Response
    {
        $posts = Post::orderByDesc('created_at')
            ->orderByDesc('id')
            ->filter(Request::only('search'))
            ->paginate(10);

        return Inertia::render('Admin/Posts/Index', [
            'filters' => Request::all('search'),
            'posts' => PostResource::collection($posts),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Posts/Create');
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $this->postService->create($request->only('title', 'content', 'thumbnail'));

        return redirect(route('admin.posts.index'))->with('success', 'Post created.');
    }

    public function show(Post $post): Response
    {
        return Inertia::render('Admin/Posts/Edit', [
            'post' => $post,
        ]);
    }

    public function edit(Post $post): Response
    {
        return Inertia::render('Admin/Posts/Edit', [
            'post' => new PostResource($post),
        ]);
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $this->postService->update($post->id, $request->only('title', 'content', 'thumbnail'));

        return redirect(route('admin.posts.index'))->with('success', 'Post updated.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->postService->delete($post->id);

        return redirect(route('admin.posts.index'))->with('success', 'Post deleted.');
    }

    public function publish(Post $post): RedirectResponse
    {
        $this->postService->publish($post->id);

        return redirect(route('admin.posts.edit', $post->id))->with('success', 'Post published.');
    }
}
