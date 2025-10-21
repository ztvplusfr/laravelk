<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterStep1'])->name('register.step1');
Route::post('/register/step1', [AuthController::class, 'processStep1'])->name('register.step1.process');
Route::get('/register/step2', [AuthController::class, 'showRegisterStep2'])->name('register.step2');
Route::post('/register/step2', [AuthController::class, 'processStep2'])->name('register.step2.process');

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
    Route::get('/movies', [App\Http\Controllers\HomeController::class, 'movies'])->name('movies');
    Route::get('/series', [App\Http\Controllers\HomeController::class, 'series'])->name('series');
    Route::get('/movie/{id}', [App\Http\Controllers\HomeController::class, 'showMovie'])->name('movie.show');
    Route::get('/series/{id}', [App\Http\Controllers\HomeController::class, 'showSeries'])->name('series.show');
    Route::get('/watch/series/{seriesId}/season/{seasonNumber}/episode/{episodeNumber}/{videoId?}', [App\Http\Controllers\HomeController::class, 'watchEpisode'])->name('watch.episode');
    Route::get('/watch/movie/{movieId}/{videoId?}', [App\Http\Controllers\HomeController::class, 'watchMovie'])->name('watch.movie');
    Route::get('/account', [App\Http\Controllers\HomeController::class, 'account'])->name('account');
    Route::put('/account/timezone', [App\Http\Controllers\HomeController::class, 'updateTimezone'])->name('account.update-timezone');
    Route::post('/account/avatar', [App\Http\Controllers\HomeController::class, 'updateAvatar'])->name('account.update-avatar');
    Route::delete('/account/avatar', [App\Http\Controllers\HomeController::class, 'deleteAvatar'])->name('account.delete-avatar');
    Route::delete('/account/session/{id}', [App\Http\Controllers\HomeController::class, 'destroySession'])->name('session.destroy');
    
    // Routes watchlist
    Route::get('/watchlist', [App\Http\Controllers\HomeController::class, 'watchlist'])->name('watchlist');
    Route::post('/watchlist/add', [App\Http\Controllers\HomeController::class, 'addToWatchlist'])->name('watchlist.add');
    Route::post('/watchlist/remove', [App\Http\Controllers\HomeController::class, 'removeFromWatchlist'])->name('watchlist.remove');
    
    // Routes historique
    Route::get('/history', [App\Http\Controllers\HomeController::class, 'history'])->name('history');
    Route::post('/history/add', [App\Http\Controllers\HomeController::class, 'addToHistory'])->name('history.add');
    Route::post('/history/update', [App\Http\Controllers\HomeController::class, 'updateHistory'])->name('history.update');
    Route::post('/history/check', [App\Http\Controllers\HomeController::class, 'checkHistory'])->name('history.check');
    Route::delete('/history/remove', [App\Http\Controllers\HomeController::class, 'removeFromHistory'])->name('history.remove');
    Route::delete('/history/clear', [App\Http\Controllers\HomeController::class, 'clearHistory'])->name('history.clear');
    
    // Routes administrateur
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/movies', [AdminController::class, 'movies'])->name('admin.movies');
        Route::post('/admin/sync-movies', [AdminController::class, 'syncMovies'])->name('admin.sync-movies');
        Route::get('/admin/movies/{id}/edit', [AdminController::class, 'editMovie'])->name('admin.edit-movie');
        Route::put('/admin/movies/{id}', [AdminController::class, 'updateMovie'])->name('admin.update-movie');
        Route::delete('/admin/movies/{id}', [AdminController::class, 'deleteMovie'])->name('admin.delete-movie');
        Route::get('/admin/series', [AdminController::class, 'series'])->name('admin.series');
        Route::post('/admin/sync-series', [AdminController::class, 'syncSeries'])->name('admin.sync-series');
        Route::get('/admin/series/{id}/edit', [AdminController::class, 'editSeries'])->name('admin.edit-series');
        Route::put('/admin/series/{id}', [AdminController::class, 'updateSeries'])->name('admin.update-series');
        Route::delete('/admin/series/{id}', [AdminController::class, 'deleteSeries'])->name('admin.delete-series');
        Route::get('/admin/seasons/{id}/edit', [AdminController::class, 'editSeason'])->name('admin.edit-season');
        Route::put('/admin/seasons/{id}', [AdminController::class, 'updateSeason'])->name('admin.update-season');
        Route::get('/admin/episodes/{id}/edit', [AdminController::class, 'editEpisode'])->name('admin.edit-episode');
        Route::put('/admin/episodes/{id}', [AdminController::class, 'updateEpisode'])->name('admin.update-episode');
        
        // Routes vidéos
        Route::post('/admin/videos', [AdminController::class, 'storeVideo'])->name('admin.store-video');
        Route::put('/admin/videos/{id}', [AdminController::class, 'updateVideo'])->name('admin.update-video');
        Route::delete('/admin/videos/{id}', [AdminController::class, 'deleteVideo'])->name('admin.delete-video');
        
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/import', [AdminController::class, 'import'])->name('admin.import');
        Route::post('/admin/import-movie', [AdminController::class, 'importMovie'])->name('admin.import-movie');
        Route::post('/admin/import-series', [AdminController::class, 'importSeries'])->name('admin.import-series');
        Route::get('/admin/test-tmdb', [AdminController::class, 'testTmdb'])->name('admin.test-tmdb');
        Route::get('/admin/search-tmdb', [AdminController::class, 'searchTmdb'])->name('admin.search-tmdb');
    });
});
