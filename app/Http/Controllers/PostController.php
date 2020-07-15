<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentStoreRequest;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Post;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth')->except(['show', 'index']);
        $this->authorizeResource(Post::class, 'post', ['except' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        //
        return view('client.pages.posts.index',[
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
        return view('client.pages.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Redirector
     */
    public function store(PostStoreRequest $request)
    {
        //

        $post = Post::create([
            'title' => $request->post_title,
            'published' => false,
            'text' => $request->post_text,
            'user_id' => Auth::id(),
        ]);
        $post->update([
            'slug' => Str::slug($request->post_title) . "-" . $post->id,
        ]);
        return redirect(route('post.index'))
            ->with(['success' => "'{$post->title}' post successfully created"]);
    }

    public function storeComment(CommentStoreRequest $request){
            $comment = Comment::create([
                'comment' => htmlspecialchars($request->comment_text),
                'post_id' => $request->postId,
                'user_id' => Auth::id(),
                'parent_comment_id' => $request->parent_comment_id ?? null
            ]);
            $result = [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'creator' => $comment->creator->name,
                'parent_comment_id' => $comment->parent_comment_id ?? null,
                'created_at' => $comment->created_at->format('M d Y, H:i'),
            ];
            return json_encode($result);
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
        $comments = Comment::all()->where('post_id', $post->id)->where('parent_comment_id', null);
        return view('client.pages.posts.show', ['post' => $post, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     * @return View
     */
    public function edit(Post $post, User $user)
    {
        //
        return view('client.pages.posts.update', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return Redirector
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        //
//        dd('update method', $request->all());

        $post->update([
            'title' => $request->post_title,
            'text' => $request->post_text,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect(route('post.index'))
            ->with(['success' => "'{$post->title}' post successfully updated"]);
    }

    /**
     * Publish the specified resource.
     *
     * @param  Post $post
     * @return Redirector|RedirectResponse
     */
    public function publish(Request $request){
        $status = '';
        if ($request['status'] == 'published'){
            DB::table('posts')
                ->where('id', $request['id'])
                ->update(['published' => false]);
            $status = 'not published';
        } else if($request['status'] == 'not published'){
            DB::table('posts')
                ->where('id', $request['id'])
                ->update(['published' => true]);
            $status = 'published';
        }
        $result = [
            'status' => $status,
        ];

        return json_encode($result);
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

        return redirect(route('post.index'))
            ->with(['success' => "'{$post->title}' post successfully deleted"]);
    }
}
