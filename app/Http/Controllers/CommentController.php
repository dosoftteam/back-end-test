<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;   

use \App\Models\Comment; 
use Exception;
use Response;

class CommentController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = strip_tags( request()->get('search') );
         
        try {
            $arr_comments = array();

            $comments = Comment::selectRaw("post_id as postId, id,name,email,body");

            //scalable use laravel scout driver at model, run elasticsearch:9200, 
            if( trim( strlen( $search ) ) > 0 )
            {
                $comments = Comment::search($search)->get();
                if( count($comments ) > 0 ) {
                    $arr_comment_filter = array();
                    foreach ( $comments  as $comment)
                    {
                        $arr_comment_filter[]=[
                                                'postId'=> $comment->post_id ,  
                                                'id'    => $comment->id,
                                                'name'  => $comment->name,
                                                'body'  => $comment->body
                                            ];
                    }
                    $arr_comments = $arr_comment_filter;
                     
                } else {
                    $arr_comments = [];
                }
            } else {
                $comments = Comment::selectRaw("post_id as postId, id,name,email,body");
                $arr_comments = $comments->get()->toArray();
            } 

            $status = 200;
        } catch ( Exception $error )
        {
            $arr_comments = array($error->getMessage());
            $status = 500;
        } 
 
        return response($arr_comments,$status, ['Content-Type'=>'application/json']);
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
