<?php
namespace App\Http\Controllers;

use App\Http\Contracts\CommentInterface;
use App\Http\Contracts\PostInterface;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public $commentService;

    public function __construct(
        Request $request,
        PostInterface $postInterface,
        CommentInterface $commentInterface
    )
    {
        $this->request = $request;
        $this->service = $postInterface;
        $this->commentService = $commentInterface;
    }

    /**
     * @method GET
     * @link /api/posts
     */
    public function getPosts()
    {
        $this->service->findPosts();
        return $this->response();
    }

    /**
     * @method GET
     * @link /api/posts/{post}/comments
     */
    public function getPostComments(string $postID)
    {
        $this->commentService->findPostComments($postID);
        return $this->response($this->commentService->response);
    }

    /**
     * @method GET
     * @link /api/posts/{posts}
     */
    public function getPost($postID)
    {
        $this->service->findPost($postID);
        return $this->response();
    }

    /**
     * @method POST
     * @link /api/posts
     */
    public function postPost()
    {
        $this->request->validate([
           'title'  =>  'required',
           'body'   =>  'required',
           'file'   =>  'file|max:500|mimes:png,jpeg,jpg'
        ]);
        $postData = $this->request->only([
            'title', 'body', 'status', 'file'
        ]);
        $this->service->createPost($postData);
        return $this->response();
    }

    /**
     */
    public function postPostComment(Post $post)
    {
        $this->request->validate([
            'name'  =>  'required',
            'message'   =>  'required',
            'parent_id' =>  '',
        ]);

        $commentData = $this->request->only([
            'message', 'parent_id', 'name'
        ]);
        $commentData['ip'] = $this->request->ip();

        $this->commentService->createPostComment($post, $commentData);
        return $this->response($this->commentService->response);
    }

    /**
     * @method POST
     * @link /api/posts/{post}/update
     */
    public function patchPost($postID)
    {
        $this->request->validate([
            'title'  =>  '',
            'body'   =>  '',
            'file'   =>  'file|max:500|mimes:png,jpeg,jpg'
         ]);
        $postData = $this->request->only([
            'title', 'body', 'status', 'file'
        ]);
        $this->service->updatePost($postID, $postData);
        return $this->response();
    }

    /**
     * @method DELETE
     * @link /api/posts/{posts}
     */
    public function deletePost($postID)
    {
        $this->service->deletePost($postID);
        return $this->response();
    }

    /**
     * @method DELETE
     * @link /api/posts/{posts}/comments/{comment}
     */
    public function deletePostComment(string $postID, string $commentID)
    {
        $this->commentService->deleteComment($postID, $commentID);
        return $this->response($this->commentService->response);
    }
}
