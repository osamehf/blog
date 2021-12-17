<?php
namespace App\Http\Services;

use App\Http\Contracts\CommentInterface;
use App\Http\Contracts\PostInterface;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class CommentService implements CommentInterface
{
    // store model instance
    public $model;

    public $postService;

    public function __construct(
        Comment $comment,
        PostInterface $postInterface
    )
    {
        $this->model = $comment;
        $this->postService = $postInterface;
    }

    /**
     * find post comments
     * @param string @postID
     * @return Collection
     */
    public function findPostComments(string $postID): Collection
    {
        $comments = $this->model
            ->where('post_id', $postID)
            ->where('parent_id', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
        $this->response = [
            'data'  =>  $comments,
            'status'    =>  Response::HTTP_OK
        ];
        return $comments;
    }

    /**
     * find specific comment
     * @param string $commentID
     * @return Comment
     */
    public function findComment(string $commentID): Comment
    {
        $comment = $this->model->findOrFail($commentID);
        $this->response = [
            'data'  =>  $comment,
            'status'    =>  Response::HTTP_OK
        ];
        return $comment;
    }

    /**
     * create comment
     * @param array $commentData
     * @return Comment
     */
    public function createComment(array $commentData): Comment
    {
        $comment = $this->model->create($commentData);

        $this->response = [
            'data'  =>  $comment,
            'message'   =>  __('messages.created_ok'),
            'status'    =>  Response::HTTP_CREATED
        ];
        return $comment;
    }

    /**
     * create comment for post
     * @param Post $post
     * @param array $commentData
     * @return Comment
     */
    public function createPostComment(Post $post, array $commentData): Comment
    {
        $comments = $post->comments()->create($commentData);
        $this->response = [
            'message'   =>  __('messages.created_ok'),
            'status'    =>  Response::HTTP_OK,
            'data'  =>  $this->postService->findPost($post->id),
        ];
        return $comments;
    }

    /**
     * update specific comment
     * @param string $commentID
     * @param array $commentData
     * @return Comment
     */
    public function updateComment(string $commentID, array $commentData): Comment
    {
        $comment = $this->findComment($commentID);
        $comment->update($commentData);
        $comment = $this->findComment($commentID);
        $this->response = [
            'data'  =>  $comment,
            'status'    =>  Response::HTTP_OK,
            'message'   =>  __('messages.update_ok')
        ];
        return $comment;
    }

    /**
     * delete specific comment
     * @param string $postID
     * @param string $commentID
     * @return bool
     */
    public function deleteComment(string $postID, string $commentID): bool
    {
        $comment = $this->findComment($commentID);
        $comment->delete();
        $comments = $this->findPostComments($postID);
        $this->response = [
            'message'   =>  __('messages.delete_ok'),
            'status'    =>  Response::HTTP_OK,
            'data'  =>  $comments
        ];
        return true;
    }
}
