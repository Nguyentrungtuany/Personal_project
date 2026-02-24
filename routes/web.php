<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LinkMovieController;
use App\Http\Controllers\LoginFBController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Episode;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'home'])->name('homepage');

Route::get('/danh-muc/{slug}', [IndexController::class, 'category'])->name('category');
Route::get('/the-loai/{slug}', [IndexController::class, 'genre'])->name('genre');
Route::get('/quoc-gia/{slug}', [IndexController::class, 'country'])->name('country');
Route::get('/phim/{slug}', [IndexController::class, 'movie'])->name('movie');
Route::get('/xem-phim/{slug}/{tap}/{server_active}', [IndexController::class, 'watch'])->name('watch');
Route::get('/so-tap', [IndexController::class, 'episode'])->name('so-tap');
Route::get('/nam/{year}', [IndexController::class, 'year']);
Route::get('/tag/{tag}', [IndexController::class, 'tag']);
Route::get('/tim-kiem', [IndexController::class, 'timkiem'])->name('tim-kiem');
Route::get('/locphim', [IndexController::class, 'locphim'])->name('locphim');
Route::post('/add-rating', [IndexController::class, 'add_rating'])->name('add-rating');

// Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

//route admin
Route::resource('/category', CategoryController::class);
Route::post('resorting', [CategoryController::class, 'resorting'])->name('resorting');
Route::resource('/genre', GenreController::class);
Route::resource('/country', CountryController::class);
Route::resource('/movie', MovieController::class);
Route::resource('/linkmovie', LinkMovieController::class);
// thêm tập phim
Route::resource('/episode', EpisodeController::class);
Route::get('/add-episode/{id}', [EpisodeController::class, 'add_episode'])->name('add-episode');

Route::get('/select-movie', [EpisodeController::class, 'select_movie'])->name('select-movie');

Route::get('/update-year-phim', [MovieController::class, 'update_year']);
Route::get('/update-topview-phim', [MovieController::class, 'update_topview']);
Route::post('/filter-topview-phim', [MovieController::class, 'filter_topview']);
Route::get('/filter-topview-default', [MovieController::class, 'filter_default']);
Route::get('/sort_movie', [MovieController::class, 'sort_movie'])->name('sort_movie');
Route::post('/resorting_navbar', [MovieController::class, 'resorting_navbar'])->name('resorting_navbar');
Route::post('/resorting_movie', [MovieController::class, 'resorting_movie'])->name('resorting_movie');
Route::post('/update-season-phim', [MovieController::class, 'update_season']);
// thay đổi dữ liệu movie bằng ajax

//Thông tin trang web
Route::resource('/info', InfoController::class);

Route::get('auth/google', [LoginGoogleController::class, 'redirectToGoogle'])->name('login-by-google');
Route::get('auth/google/callback', [LoginGoogleController::class, 'handleGoogleCallback']);
Route::get('logout-home', [LoginGoogleController::class, 'logout_home'])->name('logout-home');

Route::get('/auth/facebook', [LoginFBController::class, 'redirectToFacebook'])->name('login-by-facebook');
Route::get('/auth/facebook/callback', [LoginFBController::class, 'handleFacebookCallback'])->name('facebook.callback');

Route::get('/category-choose', [MovieController::class, 'category_choose'])->name('category-choose');
Route::get('/country-choose', [MovieController::class, 'country_choose'])->name('country-choose');
Route::get('/trangthai-choose', [MovieController::class, 'trangthai_choose'])->name('trangthai-choose');
Route::get('/thuocphim-choose', [MovieController::class, 'thuocphim_choose'])->name('thuocphim-choose');
Route::get('/phimhot-choose', [MovieController::class, 'phimhot_choose'])->name('phimhot-choose');
Route::get('/phude-choose', [MovieController::class, 'phude_choose'])->name('phude-choose');
Route::get('/resolution-choose', [MovieController::class, 'resolution_choose'])->name('resolution-choose');
Route::post('/update-image-movie-ajax', [MovieController::class, 'update_image_movie_ajax'])->name('update-image-movie-ajax');
Route::post('/watch-video', [MovieController::class, 'watch_video'])->name('watch-video');
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/create-sitemap', function () {
    return Artisan::call('sitemap:create');
    // return what you want
});
require __DIR__ . '/auth.php';
