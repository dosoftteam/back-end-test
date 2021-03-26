<?php

use Illuminate\Support\Facades\Route; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resources([
        'comments' =>  \App\Http\Controllers\CommentController::class,
        'posts' => \App\Http\Controllers\PostController::class
]);

Route::get('/enter/{age}/{name}',function($age,$name){
    $client = Elasticsearch\ClientBuilder::create()->build();	//connect with the client
    $params = array();
    $params['body']  = array(	
      'name' => $name, 											//preparing structred data
      'age' => $age
      
    );
    $params['index'] = 'BeyBlade';
    $params['type']  = 'BeyBlade_Owner';
    $result = $client->index($params);							//using Index() function to inject the data
    var_dump($result);
});




Route::get("/remap", function(){
    $client = new \GuzzleHttp\Client();
    $result = $client->request('GET', 'https://jsonplaceholder.typicode.com/comments');
    if(  $result->getStatusCode() == 200 ) {
        $comments = json_decode( $result->getBody() );

        if(count( $comments ) > 0 )
        {
            $arr_insert = array();
            foreach(  $comments  as $comment )
            {
                $arr_insert[] = 
                [
                    "post_id" => $comment->postId,
                    "name" => $comment->name,
                    "email" => $comment->email,
                    "body" => $comment->body,
                ]; 
            } 
            //\App\Models\Comment::insert($arr_insert);
        }
         
    }

    $client_post = new \GuzzleHttp\Client();
    $result_post = $client_post->request('GET', 'https://jsonplaceholder.typicode.com/posts');
    if(  $result_post->getStatusCode() == 200 ) {
        $posts = json_decode( $result_post->getBody() );

        if(count( $posts ) > 0 )
        {
            $arr_insert_post = array();
            foreach(  $posts  as $post )
            {
                $arr_insert_post[] = 
                [
                    "user_id" => $post->userId,
                    "id" => $post->id,
                    "title" => $post->title, 
                    "body" => $post->body,
                ]; 
            } 
            //\App\Models\Post::insert($arr_insert_post);
        }
         
    } 
    
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
