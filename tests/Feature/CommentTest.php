<?php

namespace Tests\Feature;

use App\Http\Contracts\CommentInterface;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_comment()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->make();

        /** @var CommentInterface $commentService */
        $commentService = app(CommentInterface::class);

        $commentService->createPostComment($post, [
            'name' => $comment->name,
            'message' => $comment->message,
        ]);

        $this->assertEquals(200, $commentService->response['status']);
    }

    public function test_reply_comment()
    {
        $post = Post::factory()->create();
        $parentComment = Comment::factory()->create();
        $comment = Comment::factory()->create();

        /** @var CommentInterface $commentService */
        $commentService = app(CommentInterface::class);

        $commentService->createPostComment($post, [
            'name' => $comment->name,
            'message' => $comment->message,
            'parent_id' => $parentComment->id,
        ]);

        $this->assertEquals(200, $commentService->response['status']);
    }
}
