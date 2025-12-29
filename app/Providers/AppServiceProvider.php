<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Info;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
// use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\View;
use Laravel\Prompts\Table;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $phimhot_sidebar = Movie::where('phim_hot', 1)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('10')->get();
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        // total
        $category_total = Category::all()->count();
        $country_total = Country::all()->count();
        $genre_total = Genre::all()->count();
        $movie_total = Movie::all()->count();

        // tracking user activity
        // $total_user = DB::table('tracker_sessions')->count();
        // $total_user_week = DB::table('tracker_sessions')->where('created_at', '>=', Carbon::now('Asia/Ho_Chi_Minh')->subDays(7))->count();
        // $total_user_month = DB::table('tracker_sessions')->where('created_at', '>=', Carbon::now('Asia/Ho_Chi_Minh')->subMonth())->count();
        // $total_user_3months = DB::table('tracker_sessions')->where('created_at', '>=', Carbon::now('Asia/Ho_Chi_Minh')->subMonths(3))->count();
        // $total_user_thisyear = DB::table('tracker_sessions')->where('created_at', '>=', Carbon::now('Asia/Ho_Chi_Minh')->subYear())->count();

        $info = Info::find(1);
        
        
         //seo
        $data = array(
            'phimhot_sidebar' => $phimhot_sidebar,
            'phimhot_trailer' => $phimhot_trailer,
            'category_home' => $category,
            'country_home' => $country,
            'genre_home' => $genre,
            'info' => $info,
            'category_total' => $category_total,
            'country_total' => $country_total,
            'genre_total' => $genre_total,
            'movie_total' => $movie_total,
            // 'total_user' => $total_user,
            // 'total_user_week' => $total_user_week,
            // 'total_user_month' => $total_user_month,
            // 'total_user_3months' => $total_user_3months,
            // 'total_user_thisyear' => $total_user_thisyear,
        );
        view::share($data);
    }
}
