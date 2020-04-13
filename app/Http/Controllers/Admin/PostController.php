<?php

namespace App\Http\Controllers\admin;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        //
        return view('admin.posts.index',[
            'posts' => Post::paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        //
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Redirector
     */
    public function store(Request $request)
    {
        //
//        dd($request->all(), Auth::id());

        $post = Post::create([
            'title' => $request->post_title,
            'published' => false,
            'text' => $request->post_text,
            'user_id' => Auth::id(),
        ]);

        return redirect(route('admin.post.index'))
            ->with(['success' => "'{$post->title}' post successfully created"]);
    }

    public function storeComment(Request $request){
        $comment = Comment::create([
            'comment' => $request->comment_text,
            'post_id' => $request->postId,
            'user_id' => Auth::id(),
            'parent_comment_id' => $request->parent_comment_id ?? null,
        ]);
        $result = [
            'id' => $comment->id,
            'comment' => $comment->comment,
            'creator' => $comment->creator->name,
            'parent_comment_id' => $comment->parent_comment_id ?? null,
            'created_at' => $comment->created_at->format('M d Y, H:i'),
        ];
        echo json_encode($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return View
     */
    public function show(Post $post)
    {
        //
//        dd($post);
        $comments = Comment::all()->where('post_id', $post->id);
        return view('admin.posts.show', ['post' => $post, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     * @return View
     */
    public function edit(Post $post)
    {
        //
        return view('admin.posts.update', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return Redirector
     */
    public function update(Request $request, Post $post)
    {
        //
//        dd('update method', $request->all());

        $post->update([
            'title' => $request->post_title,
            'text' => $request->post_text,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect(route('admin.post.index'))
            ->with(['success' => "'{$post->title}' post successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return Redirector|RedirectResponse
     */
    public function destroy(Post $post)
    {
        //
        try {
            $post->delete();
        } catch (\Exception $e) {
            return back('Something went wrong')->withInput();
        }

        return redirect(route('admin.post.index'))
            ->with(['success' => "'{$post->title}' post successfully deleted"]);
    }
}
