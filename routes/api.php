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

Route::get('/notifications-count', function (Request $request) {
    $user = $request->user();
    if (!$user) return response()->json(['count' => 0]);

    $count = 0;
    if ($user->isPerson()) {
        $count = $user->offersReceived()->where('status', 'pending')->count();
    } else {
        $count = $user->offersSent()->whereIn('status', ['accepted', 'rejected'])->count();
    }

    return response()->json(['count' => $count]);
})->middleware('auth:sanctum');
