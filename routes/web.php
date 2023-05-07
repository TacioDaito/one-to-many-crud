<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create/{id}/{title}/{body}', function ($id, $title, $body) {
    
    $postAttributes = ['title' => $title, 'body' => $body];
    $post = Post::create($postAttributes);
    $user = User::findOrFail($id);
    $user->posts()->save($post);

    echo 'Body: ' . $post->body . '<br>';
    echo 'Title: ' . $post->title . '<br>';
    echo 'Post id: ' . $post->id . '<br>';

});

Route::get('/read/{id}', function ($id) {
    
    $user = User::findOrFail($id);

    foreach ($user->posts as $post) {
        echo '---------------------------<br>';
        echo 'Title: ' . $post->title . '<br>';
        echo 'Body: ' . $post->body . '<br>';
        echo 'Post id: ' . $post->id . '<br>';
    }
    
});

Route::get('/update/{user_id}/{post_id}/{title}/{body}', function ($user_id, $post_id, $title, $body) {

    $user = User::findOrFail($user_id);
    $post = $user->posts()->whereId($post_id);
    $postAttributes = ['title' => $title, 'body' => $body];
    $post->update($postAttributes);

    echo 'Title: ' . $title . '<br>';
    echo 'Body: ' . $body . '<br>';
    echo 'Post id: ' . $post_id . '<br>';

});

Route::get('/delete/{user_id}/{post_id}', function ($user_id, $post_id) {
    
    $user = User::findOrFail($user_id);
    $post = $user->posts()->whereId($post_id);
    $post->delete();

    return redirect('/read/' . $user_id);
    
});