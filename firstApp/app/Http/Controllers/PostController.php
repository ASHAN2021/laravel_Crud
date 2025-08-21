<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function deletePost(Post $post)
    {
        if (auth()->user()->id === $post['user_id']) {
            $post->delete();
        }
        return redirect('/');
    }

    public function actuallyUpdatePost(Request $request, Post $post)
    {

        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $post->update($incomingFields);
        return redirect('/');
    }

    public function showEditScreen(Post $post)
    {
        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }
        return view('edit-post', ['post' => $post]);
    }

    public function createPost(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();
        Post::create($incomingFields);
        return redirect('/');
    }

    public function showPost(Post $post)
    {
        $comments = $post->comments()->with('user')->latest()->get();
        return view('post-detail', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function addComment(Request $request, Post $post)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You must be logged in to comment');
        }

        $incomingFields = $request->validate([
            'content' => 'required|min:1|max:1000'
        ]);

        $incomingFields['content'] = strip_tags($incomingFields['content']);
        $incomingFields['user_id'] = auth()->id();
        $incomingFields['post_id'] = $post->id;

        Comment::create($incomingFields);

        return redirect("/post/{$post->id}#comments")->with('success', 'Comment added successfully!');
    }

    public function updateComment(Request $request, Comment $comment)
    {
        if (!auth()->check() || auth()->id() !== $comment->user_id) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        $incomingFields = $request->validate([
            'content' => 'required|min:1|max:1000'
        ]);

        $incomingFields['content'] = strip_tags($incomingFields['content']);
        $comment->update($incomingFields);

        return redirect("/post/{$comment->post_id}#comments")->with('success', 'Comment updated successfully!');
    }

    public function deleteComment(Comment $comment)
    {
        if (!auth()->check() || auth()->id() !== $comment->user_id) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        $postId = $comment->post_id;
        $comment->delete();

        return redirect("/post/{$postId}#comments")->with('success', 'Comment deleted successfully!');
    }
}
