<?php

namespace App\Http\Contracts;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface CommentInterface
{
    public function findPostComments(string $postID): Collection;

    public function findComment(string $commentID): Comment;

    public function createComment(array $commentData): Comment;

    public function createPostComment(Post $post, array $commentData): Comment;

    public function updateComment(string $commentID, array $commentData): Comment;

    public function deleteComment(string $postID, string $commentID): bool;
}
