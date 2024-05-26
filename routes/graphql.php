<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\GraphQL\Queries\TasksQuery;
use Rebing\GraphQL\GraphQLController;
/*
|--------------------------------------------------------------------------
| GraphQL Routes
|--------------------------------------------------------------------------
|
| Here is where you can register GraphQL routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "graphql" middleware group. Make something great!
|
*/

// Route::prefix('graphql')->middleware(['sanctum.auth'])->group(function () {
//     Route::graphql('query', [
//         'middleware' => ['sanctum.auth'],
//         'as' => 'graphql.query',
//         'uses' => TasksQuery::class,
//     ]);
// });

Route::middleware(['sanctum.auth'])->group(function () {
    Route::post('graphql', [GraphQLController::class, 'query'])->name('graphql.mutation');
    Route::get('graphql', [GraphQLController::class, 'query'])->name('graphql.query');
});
