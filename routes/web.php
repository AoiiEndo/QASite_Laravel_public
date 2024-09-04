<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestCategoryController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseFavoriteController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InquiryController;
use \App\Http\Middleware\CheckAdmin;
use \App\Http\Middleware\SecurityHeaders;


Route::middleware(SecurityHeaders::class)->group(function () {
    // 利用規約
    Route::get('/terms', function () {
        return view('terms');
    })->name('terms');

    //プライバシーポリシー
    Route::get('/privacyPolicy', function () {
        return view('privacyPolicy');
    })->name('privacyPolicy');

    // お問い合わせ
    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');
    Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

    // ログイン
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // 新規ユーザ
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/', [QuestionController::class, 'index'])->name('questions.index');

    Route::middleware('auth')->group(function () {
        // 質問
        Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
        Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

        // 回答
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

        // 演習問題
        Route::get('exercises', [ExerciseController::class, 'index'])->name('exercises.index');
        Route::get('exercises/create', [ExerciseController::class, 'create'])->name('exercises.create');
        Route::get('exercises/get', [ExerciseController::class, 'getExercises'])->name('exercises.get');
        Route::post('exercises/store', [ExerciseController::class, 'store'])->name('exercises.store');
        Route::post('exercises/edit', [ExerciseController::class, 'edit'])->name('exercises.edit');
        Route::post('exercises/search', [ExerciseController::class, 'search'])->name('exercises.search');
        Route::post('exercises/destroy', [ExerciseController::class, 'destroy'])->name('exercises.destroy');
        
        Route::get('exercises/favorites', [ExerciseFavoriteController::class, 'index'])->name('exercises.favorites.index');
        Route::post('exercises/favorites/{id}', [ExerciseFavoriteController::class, 'toggleFavorite'])->name('exercises.favorites.toggle');
        // Route::delete('exercises/favorites/{exercise}', [ExerciseFavoriteController::class, 'destroy'])->name('exercises.favorites.destroy');

        // フォロー機能
        Route::post('/follow', [FollowController::class, 'follow'])->name('follow.follow');
        Route::post('/unfollow', [FollowController::class, 'unfollow'])->name('follow.unfollow');
        Route::get('/following', [FollowController::class, 'getFollowing'])->name('following');
        Route::get('/followers', [FollowController::class, 'getFollowers'])->name('followers');

        // お問い合わせ管理画面
        Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries')->middleware(CheckAdmin::class);
        Route::post('/inquiries/update', [InquiryController::class, 'update'])->name('inquiry.update')->middleware(CheckAdmin::class);
    });

    Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');
    Route::get('/exercises/{id}', [ExerciseController::class, 'show'])->name('exercises.show');
});