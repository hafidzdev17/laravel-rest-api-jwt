<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    protected $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index() {
        $post = $this->postRepository->getAll();
        return PostResource::collection($post);
    }

    public function show($id)
    {
        $post = $this->postRepository->find($id);
        return new PostResource($post);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $post = $this->postRepository->create($data);
        return new PostResource($post);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $post = $this->postRepository->find($id);

        $post->update($data);
        return new PostResource($post);
    }

    public function destroy($id) {
        $post = $this->postRepository->delete($id);
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
