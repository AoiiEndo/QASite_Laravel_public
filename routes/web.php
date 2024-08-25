<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestCategoryController;

// ログイン
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 新規ユーザ
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth')->group(function () {
    // 質問
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

    // 回答
    Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');
    Route::post('/questions/{id}/answer', [QuestionController::class, 'answer'])->name('answers.store');
    Route::post('/answers/{id}', [AnswerController::class, 'markAsBest'])->name('answers.best');

    // 検索
    Route::post('/questions/search', [QuestionController::class, 'search'])->name('questions.search');

    // プロフィール
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit');

    // テスト関連
    Route::post('categories/store', [TestCategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/list', [TestController::class, 'getCategories'])->name('categories.list');
    Route::post('categories/update/{id}', [TestCategoryController::class, 'update'])->name('categories.update');
    Route::post('tests/results', [TestController::class, 'results'])->name('tests.results');
    Route::post('tests/store', [TestController::class, 'storeTest'])->name('tests.store');
    Route::post('tests/update/{id}', [TestController::class, 'update'])->name('tests.update');
});
