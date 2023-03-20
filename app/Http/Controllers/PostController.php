<?php

namespace App\Http\Controllers;

//use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
class PostController extends Controller
{

    public function __construct()
    {
//        $this->middleware(function ($request, $next) {
//            if(Auth::user()->cannot('isAdmin', Post::class)){
//                abort(403,'you cannot access this page');
//            }
//            return $next($request);
//        });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts/post');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $post = new Post();
        $post->title = $request->title;
        $post->body  = $request->body;
        $user->post()->save($post);
        return redirect(route('post_index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        $this->authorize('isAdmin',Post::class);
        if(Auth::user()->cannot('isAdmin',Post::class)){
            abort(403,'you cannot access this page');
        }
        $data = Post::find($id);
//        This is for Gate
//        if( !Gate::allows('isAdmin',$data)){
//            abort(403,'you are not authorized to do this'   );
//        }
        return view('editpost',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $post = Post::find($id);
       $post->title = $request->title;
       $post->body  = $request->body;
       $post->save();
       return redirect(route('dashboard'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        This is for policy
        $this->authorize('isAdmin',Post::class);
        $delete = Post::destroy($id);
//        This is for Gate
//        if( !Gate::allows('isAdmin',$delete)){
//            abort(403,'you are not authorized to do this');
//        }
        return redirect(route('dashboard'));
    }
}
