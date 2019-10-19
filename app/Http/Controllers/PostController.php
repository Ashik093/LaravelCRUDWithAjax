<?php

namespace App\Http\Controllers;

use App\Post;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('post');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=[
            'title'=>$request['title'],
            'author'=>$request['author'],
            'details'=>$request['details'],
        ];
        return Post::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post=Post::find($id);
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post=Post::find($id);
        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post=Post::find($id);
        $post->title=$request['title'];
        $post->author=$request['author'];
        $post->details=$request['details'];
        $post->update();
        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
    }

    public function allPost(){
        $post = Post::all();
        return Datatables::of($post)->addColumn('action',function($post){
            return '<div class="btn-group"><a onclick="showData('.$post->id.')" class="btn btn-sm btn-success text-white">Show</a>'.
                    '<a onclick="editForm('.$post->id.')" class="btn btn-sm btn-info text-white">Edit</a>'.
                    '<a onclick="deleteData('.$post->id.')" class="btn btn-sm btn-danger text-white">Delete</a></div>';
        })->make(true);
    }
}
