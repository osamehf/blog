<?php

namespace App\Http\Contracts;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostInterface
{
    public function findPosts(): Collection;

    public function findPost(string $postID): Post;

    public function createPost(array $postData): Post;

    public function updatePost(string $postID, array $postData): Post;

    public function deletePost(string $postID): bool;
}
