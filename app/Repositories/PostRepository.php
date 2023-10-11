<?php

namespace App\Repositories;
use App\Models\Post;

class PostRepository
{
    protected $post;
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
    public function getAll() {
       return $this->post->all();
    }
    public function find($id) {
        return $this->post->find($id);
    }
    public function create(array $data) {
        $data['user_id'] = auth()->user()->id;
        return $this->post->create($data);
    }
    public function update($id, array $data) {
        $post = $this->post->find($id);
        $data['user_id'] = auth()->user()->id;
        $post->update($data);
        return $post;
    }
    public function delete($id)
    {
        return $this->post->find($id)->delete();
    }

}
