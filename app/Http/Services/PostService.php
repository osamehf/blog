<?php
namespace App\Http\Services;

use App\Http\Contracts\PostInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class PostService implements PostInterface
{
    // store model instance
    public $model;

    public function __construct(Post $post)
    {
        $this->model = $post;    
    }

    /**
     * return all posts
     * @return Collection
     */
    public function findPosts(): Collection
    {
        $posts = $this->model
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->get();
        $this->response = [
            'data'  =>  $posts,
            'status'    =>  Response::HTTP_OK
        ];
        return $posts;
    }

    /**
     * return specific post
     * @param string $postID
     * @return Post
     */
    public function findPost(string $postID): Post
    {
        $post = $this->model
            ->where('id', $postID)
            ->with(['comments' => function($comments) {
                return $comments
                    ->where('parent_id', 0)
                    ->with(['replies' => function($replies){
                        return $replies->orderBy('created_at', 'DESC');
                    }])
                    ->where('status', 1)
                    ->orderBy('created_at', 'DESC');
            }])
            ->withCount(['comments'])
            ->first();
        $this->response = [
            'data'  =>  $post,
            'status'    =>  Response::HTTP_OK
        ];
        return $post;
    }

    /**
     * create post
     * @param array $postData
     * @return Post
     */
    public function createPost(array $postData): Post
    {
        if ( isset($postData['file']) ) {
            $postData['file'] = $postData['file']->store('public/uploads/posts');
        }

        $post = $this->model->create($postData);
        $this->response = [
            'data'  =>  $post,
            'status'    =>  Response::HTTP_CREATED,
            'message'   =>  __('messages.create_ok')
        ];
        return $post;
    }

    /**
     * update specific post
     * @param string @postID
     * @param array @postData
     * @return Post
     */
    public function updatePost(string $postID, array $postData): Post
    {
        if ( isset($postData['file']) ) {
            $postData['file'] = $postData['file']->store('public/uploads/posts');
        }
        $post = $this->findPost($postID);
        $post->update($postData);
        $this->response = [
            'data'  =>  $post,
            'status'    =>  Response::HTTP_OK,
            'message'   =>  __('messages.update_ok')
        ];
        return $post;
    }

    /**
     * delete specific post
     * @param string @postID
     * @return bool
     */
    public function deletePost(string $postID): bool
    {
        $post = $this->findPost($postID);
        $post->delete();
        $this->response = [
            'message'   =>  __('messages.delete_ok'),
            'status'    =>  Response::HTTP_OK
        ];
        return true;
    }
}