<?php

use App\Http\Controllers\Admin\MateriController;
use App\Http\Controllers\Admin\QuestionsController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\ResultsController;
use App\Http\Controllers\Admin\User_answerController;
use App\Http\Controllers\Viewer\MateriController as ViewerMateriController;
use App\Http\Controllers\Viewer\QuestionsController as ViewerQuestionsController;
use App\Http\Controllers\Viewer\QuizController as ViewerQuizController;
use App\Http\Controllers\Viewer\ResultsController as ViewerResultsController;
use App\Http\Controllers\Viewer\User_answerController as ViewerUser_answerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes(['reset' => false, 'verify' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Group Route ADMIN
Route::prefix('admin')->group(function () {
    Route::group(['middleware' => ['auth','role:admin']], function () {
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin.dashboard');

        // Resource Materis dengan Nama Unik
        Route::resource('materis', MateriController::class)->names([
            'index' => 'admin.materis.index',
            'create' => 'admin.materis.create',
            'store' => 'admin.materis.store',
            'show' => 'admin.materis.show',
            'edit' => 'admin.materis.edit',
            'update' => 'admin.materis.update',
            'destroy' => 'admin.materis.destroy',
        ]);

        Route::resource('quiz', QuizController::class);
        Route::resource('questions', QuestionsController::class);
        Route::resource('results', ResultsController::class);
        Route::resource('user-answers', User_answerController::class);
    });
});

// Group Route VIEWER
Route::prefix('viewer')->group(function () {
    Route::group(['middleware' => ['auth', 'role:admin|viewer']], function () {
        Route::get('/dashboard', [ViewerMateriController::class, 'index'])->name('viewer.dashboard');

        Route::resource('materi', ViewerMateriController::class)->names([
            'index' => 'viewer.materi.index',
            'show' => 'viewer.materi.show',
        ]);

        Route::resource('quizs', ViewerQuizController::class);
        Route::resource('question', ViewerQuestionsController::class);
        Route::resource('result', ViewerResultsController::class);
        Route::resource('user-answer', ViewerUser_answerController::class);
    });
});
