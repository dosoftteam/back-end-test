<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use \App\Models\Comment;
use Exception;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $comments = Comment::selectRaw("post_id as postId, id,name,email,body")->get()->toArray();
            $status = 200;
        } catch ( Exception $error )
        {
            $comments = array();
            $status = 500;
        } 
        return response($comments,$status, ['Content-Type'=>'application/json']);
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
        $comment = Comment::find($id);

        $data = array();
        if( $comment != null ) { 
            $data = [
                "postId" => $comment->post_id,
                "id"     => $comment->id,
                "name"   => $comment->name,
                "email"  => $comment->email, 
                "body"   => $comment->body 
            ];
        }  
        return response($data,200, ['Content-Type'=>'application/json']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
