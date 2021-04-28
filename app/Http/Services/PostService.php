<?php

namespace App\Http\Services;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PostService
{
    protected $postModel;

    public function __construct(Post $postModel)
    {
        $this->postModel = $postModel;
    }

    public function getAll()
    {
        $user = Auth::user();
        if ($user->isWriter()) {
            $posts = $user->posts;
            return $posts;
        }
        if ($user->isOrganization()) {
            $allPosts = new Collection();
            // find orginazation using by relation ship belongTo
            $organization = $user->organization;
            // find all users using by relation ship hasMany
            $users = $organization->users;
            foreach ($users as $key => $user) {
                $allPosts = $allPosts->concat($user->posts);
            }
            return $allPosts;
        }
        return $this->postModel->all();
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return $post;
    }

    public function store($request)
    {
        $post = new Post();
        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->is_active = $request->is_active;
        $post->save();
        return $post;
    }

    public function update($request, $id)
    {
        $post = Post::findOrFail($id);
        if ($request->has('title')) {
            $post->title = $request->title;
        }
        if ($request->has('content')) {
            $post->content = $request->content;
        }
        if ($request->has('is_active')) {
            $post->is_active = $request->is_active;
        }
        $post->save();
        return $post;
    }
}
