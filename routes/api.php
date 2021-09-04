<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/questions', [QuestionController::class, 'index']);
Route::post('/questions', [QuestionController::class, 'store']);
Route::get('/questions/{id}', [QuestionController::class, 'show']);
Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);
Route::get('/questions/search/{title}', [UrlController::class, 'search']);

Route::post('answer/question/{id}', [AnswerController::class, 'store']);
Route::get('answers/question/{id}', [AnswerController::class, 'getAnswers']);
Route::delete('/answers/{id}', [AnswerController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
