<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/posts',function(){
    return response()->json([
        'posts' => [
            ['id' => 1, 'title' => 'Post 1'],   
        ]]);
});*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
