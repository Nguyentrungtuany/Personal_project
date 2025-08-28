<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Episode;
use App\Models\Movie_Genre;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function locphim() 
{
    $sapxep = $_GET['order'];
    $genre_get = $_GET['genre'];
    $country_get = $_GET['country'];
    $year_get = $_GET['year'];

    if($sapxep == '' && $genre_get == '' && $country_get == '' && $year_get == '') {
        return redirect()->back();
    } else {
        $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::withCount('episode')->where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhap', 'DESC')->take(30)->get();
        $phimhot_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('ngaycapnhap', 'DESC')->take(10)->get();
        $movie = Movie::withCount('episode');
        if($genre_get) {
            $movie = $movie->where('genre_id', '=', $genre_get);
        } elseif($country_get) {
            $movie = $movie->where('country_id', '=', $country_get);
        } elseif($year_get) {
            $movie = $movie->where('year', '=', $year_get);
        // }elseif($order){
        //     $movie = $movie->orderBy('title', 'DESC');
        } 
            $movie = $movie->orderBy('ngaycapnhap', 'DESC')->paginate(40);

        return view('page.include.locphim', compact('category', 'genre', 'country', 'movie', 'phimhot_sidebar', 'phimhot_trailer'));
    }
}
    public function timkiem()
    {
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
            $country = Country::orderBy('id', 'DESC')->get();
            $phimhot_sidebar = Movie::where('phim_hot', 1)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('30')->get();
            $phimhot_trailer = Movie::where('resolution', 5)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('10')->get();
            $genre = Genre::orderBy('id', 'DESC')->get();
            $movie = Movie::where('title', 'LIKE', '%' . $search . '%')->orderBy('ngaycapnhap', 'DESC')->paginate(40);
            return view('page.timkiem', compact('category', 'country', 'genre', 'search', 'movie', 'phimhot_sidebar', 'phimhot_trailer'));
        } else {
            return redirect()->to('/');
        }
    }
    public function home()
    {
        $phimhot = Movie::where('phim_hot', 1)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('10')->get();
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $Category_home = Category::with('movie')->orderBy('id', 'DESC')->where('status', 1)->get();
        return view('page.home', compact('category', 'country', 'genre', 'Category_home', 'phimhot', 'phimhot_sidebar', 'phimhot_trailer')); // gọi file resources/views/page/home.blade.php
    }

    public function category($slug)
    {
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('10')->get();

        $genre = Genre::orderBy('id', 'DESC')->get();
        $cate_slug = Category::where('slug', $slug)->first();
        $movie = Movie::where('category_id', $cate_slug->id)->orderBy('ngaycapnhap', 'DESC')->paginate(40);
        return view('page.category', compact('category', 'country', 'genre', 'cate_slug', 'movie', 'phimhot_sidebar', 'phimhot_trailer')); // gọi file resources/views/page/category.blade.php
    }
    public function year($year)
    {
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('10')->get();

        $genre = Genre::orderBy('id', 'DESC')->get();
        $year = $year;
        $movie = Movie::where('year', $year)->orderBy('ngaycapnhap', 'DESC')->paginate(40);
        return view('page.year', compact('category', 'country', 'genre', 'year', 'movie', 'phimhot_sidebar', 'phimhot_trailer')); // gọi file resources/views/page/category.blade.php
    }
    public function tag($tag)
    {
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('10')->get();

        $genre = Genre::orderBy('id', 'DESC')->get();
        $tag = $tag;
        $movie = Movie::where('tags', 'LIKE', '%' . $tag . '%')->orderBy('ngaycapnhap', 'DESC')->paginate(40);
        return view('page.tag', compact('category', 'country', 'genre', 'tag', 'movie', 'phimhot_sidebar', 'phimhot_trailer')); // gọi file resources/views/page/category.blade.php
    }
    public function genre($slug)
    {
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('10')->get();

        $genre = Genre::orderBy('id', 'DESC')->get();
        $genre_slug = Genre::where('slug', $slug)->first();
        // nhiều thể loại
        $movie_genre = Movie_Genre::where('genre_id', $genre_slug->id)->get();
        $many_genre = [];
        foreach ($movie_genre as $key => $movi) {
            $many_genre[] = $movi->movie_id;
        }
        $movie = Movie::whereIn('id', $many_genre)->withCount('episode')->orderBy('ngaycapnhap', 'DESC')->paginate(40);
        return view('page.genre', compact('category', 'country', 'genre', 'genre_slug', 'movie', 'phimhot_sidebar', 'phimhot_trailer'));
    }

    public function country($slug)
    {
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('10')->get();

        $genre = Genre::orderBy('id', 'DESC')->get();
        $country_slug = Country::where('slug', $slug)->first();
        $movie = Movie::where('country_id', $country_slug->id)->orderBy('ngaycapnhap', 'DESC')->paginate(40);

        return view('page.country', compact('category', 'country', 'genre', 'country_slug', 'movie', 'phimhot_sidebar', 'phimhot_trailer'));
    }
    public function movie($slug)
    {        
                
        $genre = Genre::orderBy('id', 'DESC')->get();
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->get();

        $movie = Movie::with('category', 'country', 'genre', 'movie_genre')->where('slug', $slug)->where('status', 1)->first();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('10')->get();
        $episode = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode', 'DESC')->take('3')->get();

        
        $related = Movie::with('category', 'country', 'genre')->where('category_id', $movie->category_id)->orderBy(DB::raw('RAND()'))->whereNotIn('slug', [$slug])->get();
        // lấy 3 tập gần nhất         
        $episode_tapdau = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode', 'ASC')->take(1)->first();

        // Lấy tổng số tập đã thêm
        $episode_current_list = Episode::with('movie')->where('movie_id', $movie->id)->get();
        $episode_current_list_count = $episode_current_list->count();

        return view('page.movie', compact('category', 'country', 'genre', 'movie', 'related', 'phimhot_sidebar', 'phimhot_trailer', 'episode', 'episode_tapdau', 'episode_current_list_count'));
    }
    public function watch($slug,$tap)
    {               
        $movie = Movie::with('category', 'country', 'genre', 'country', 'movie_genre', 'episode')->where('slug', $slug)->where('status', 1)->first();

        if(isset($tap)){
            $tapphim = $tap;
            $tapphim = substr($tap, 4, 1);
            $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->first();
        }else{
            $tapphim = 1;
            $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->first();

        }
        $tapphim = substr($tap, 4, 20);

        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->take('10')->get();
        $genre = Genre::orderBy('id', 'DESC')->get();        
        $related = Movie::with('category', 'country', 'genre')->where('category_id', $movie->category_id)->orderBy(DB::raw('RAND()'))->whereNotIn('slug', [$slug])->get();
        
        $episode = Episode::where('movie_id',$movie->id)->where('episode',$tapphim)->first();
        $episode_order = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode', 'ASC')->get();
        return view('page.watch', compact('category', 'country', 'genre', 'movie', 'phimhot_sidebar','phimhot_trailer', 'episode','tapphim','related', 'episode_order'));
    }
    public function episode()
    {
        return view('page.episode'); // gọi file resources/views/page/episode.blade.php
    }
}
