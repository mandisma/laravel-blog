<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostThumbnailController extends AdminController
{
    public function destroy(Request $request, Post $post): Response
    {
        $post->getFirstMedia('thumbnail')->delete();

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('success', 'Thumbnail removed');
    }
}
