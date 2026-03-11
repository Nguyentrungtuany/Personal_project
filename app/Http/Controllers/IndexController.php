<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Episode;
use App\Models\Movie_Genre;
use App\Models\Rating;
use App\Models\Info;
use App\Models\LinkMovie;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Database\Eloquent\Model;


// class PostController extends Controller
// {
//     public function store(PostRequest $request)
//     {
//         $post = Post::create($request->only(['title', 'body']));

//         if ($post instanceof Model) {
//             toastr()->success('Data has been saved successfully!');

//             return redirect()->route('posts.index');
//         }

//         toastr()->error('An error has occurred please try again later.');

//         return back();
//     }
// }

class IndexController extends Controller
{
    public function locphim()
    {
        $meta_title = 'Lọc Phim';
        $meta_description = 'Tìm kiếm và lọc phim theo thể loại, quốc gia, năm sản xuất';
        $meta_image = '';
        $sapxep = $_GET['order'];
        $genre_get = $_GET['genre'];
        $country_get = $_GET['country'];
        $year_get = $_GET['year'];

        if ($sapxep == '' && $genre_get == '' && $country_get == '' && $year_get == '') {
            return redirect()->back();
        } else {
            $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();

            $phimhot_sidebar = Movie::withCount('episode')->where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhap', 'DESC')->take(30)->get();
            $phimhot_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('ngaycapnhap', 'DESC')->take(10)->get();
            $movie = Movie::withCount('episode');
            if ($genre_get) {
                $movie = $movie->where('genre_id', $genre_get);
            } elseif ($country_get) {
                $movie = $movie->where('country_id',  $country_get);
            } elseif ($year_get) {
                $movie = $movie->where('year', $year_get);
                // }elseif($order){
                //     $movie = $movie->orderBy('title', 'DESC');
            }
            $movie = $movie->orderBy('ngaycapnhap', 'DESC')->paginate(40);

            return view('page.locphim', compact('movie', 'meta_title', 'meta_description', 'meta_image'));
        }
    }
    public function timkiem()
    {
        if (isset($_GET['search'])) {
            $search = $_GET['search'];



            $movie = Movie::where('title', 'LIKE', '%' . $search . '%')->orderBy('ngaycapnhap', 'DESC')->paginate(40);
            return view('page.timkiem', compact('search', 'movie'));
        } else {
            return redirect()->to('/');
        }
    }
    public function home()
    {
        $info = Info::find(1);
        $meta_title = $info->title;
        $meta_description = $info->description;
        $meta_image = '';
        $phimhot = Movie::where('phim_hot', 1)->orderBy('ngaycapnhap', 'DESC')->where('status', 1)->get();



        $Category_home = Category::with(['movie' => function ($q) {
            $q->withCount('episode')->where('status', 1);
        }])->orderBy('position', 'ASC')->where('status', 1)->get();
        return view('page.home', compact('Category_home', 'phimhot', 'info', 'meta_title', 'meta_description', 'meta_image')); // gọi file resources/views/page/home.blade.php
    }

    public function category($slug)
    {
        $cate_slug = Category::where('slug', $slug)->first();
        $meta_title = $cate_slug->title;
        $meta_description = $cate_slug->description;
        $meta_image = '';

        $movie = Movie::where('category_id', $cate_slug->id)->orderBy('position', 'ASC')->paginate(40);
        return view('page.category', compact('cate_slug', 'movie', 'meta_title', 'meta_description', 'meta_image')); // gọi file resources/views/page/category.blade.php
    }
    public function year($year)
    {
        $meta_title = 'Phim Năm ' . $year;
        $meta_description = 'Tìm phim năm ' . $year;
        $meta_image = '';

        $year = $year;
        $movie = Movie::where('year', $year)->orderBy('ngaycapnhap', 'DESC')->paginate(40);
        return view('page.year', compact('year', 'movie', 'meta_title', 'meta_description', 'meta_image')); // gọi file resources/views/page/category.blade.php
    }
    public function tag($tag)
    {
        $meta_title = 'Tag: ' . $tag;
        $meta_description = 'Tìm phim theo tag: ' . $tag;
        $meta_image = '';

        $tag = $tag;
        $movie = Movie::where('tags', 'LIKE', '%' . $tag . '%')->orderBy('ngaycapnhap', 'DESC')->paginate(40);
        return view('page.tag', compact('tag', 'movie', 'meta_title', 'meta_description', 'meta_image')); // gọi file resources/views/page/category.blade.php
    }
    public function genre($slug)
    {

        $genre_slug = Genre::where('slug', $slug)->first();
        $meta_title = $genre_slug->title;
        $meta_description = $genre_slug->description;
        $meta_image = '';
        // nhiều thể loại
        $movie_genre = Movie_Genre::where('genre_id', $genre_slug->id)->get();
        $many_genre = [];
        foreach ($movie_genre as $key => $movi) {
            $many_genre[] = $movi->movie_id;
        }
        $movie = Movie::whereIn('id', $many_genre)->withCount('episode')->orderBy('ngaycapnhap', 'DESC')->paginate(40);
        return view('page.genre', compact('genre_slug', 'movie', 'meta_title', 'meta_description', 'meta_image')); // gọi file resources/views/page/category.blade.php
    }

    public function country($slug)
    {

        $country_slug = Country::where('slug', $slug)->first();
        $meta_title = $country_slug->title;
        $meta_description = $country_slug->description;
        $meta_image = '';
        $movie = Movie::where('country_id', $country_slug->id)->orderBy('ngaycapnhap', 'DESC')->paginate(40);

        return view('page.country', compact('country_slug', 'movie', 'meta_title', 'meta_description', 'meta_image'));
    }
    public function movie($slug)
    {

        $movie = Movie::with('movie_genre')->where('slug', $slug)->where('status', 1)->first();
        $meta_title = $movie->title;
        $meta_description = $movie->description;
        $meta_image = url('uploads/movie/' . $movie->image);
        $episode = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode', 'DESC')->take('3')->get();


        $related = Movie::with('genre')->where('category_id', $movie->category_id)->orderBy(DB::raw('RAND()'))->whereNotIn('slug', [$slug])->get();
        // lấy 3 tập gần nhất
        $episode_tapdau = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode', 'ASC')->take(1)->first();

        // Lấy tổng số tập đã thêm
        $episode_current_list = Episode::with('movie')->where('movie_id', $movie->id)->get();
        $episode_current_list_count = $episode_current_list->count();
        $rating = Rating::where('movie_id', $movie->id)->avg('rating');
        $rating = round($rating);
        $count_total = Rating::where('movie_id', $movie->id)->count();
        $count_views = $movie->count_views;
        $count_views++;
        $movie->count_views = $count_views;
        $movie->save();
        return view('page.movie', compact('movie', 'related', 'episode', 'episode_tapdau', 'episode_current_list_count', 'rating', 'count_total', 'meta_title', 'meta_description', 'meta_image')); // gọi file resources/views/page/movie.blade.php
    }
    public function add_rating(Request $request)
    {
        $data = $request->all();
        $ip_address = $request->ip();
        $rating_count = Rating::where('movie_id', $data['movie_id'])->where('ip_address', $ip_address)->count();
        if ($rating_count > 0) {
            echo 'exist';
        } else {
            $rating = new Rating();
            $rating->movie_id = $data['movie_id'];
            $rating->rating = $data['index'];
            $rating->ip_address = $ip_address;
            $rating->save();
            echo 'done';
        }
    }

    public function watch($slug, $tap, $server_active)
    {
        $movie = Movie::with('movie_genre', 'episode')->where('slug', $slug)->where('status', 1)->first();
        $meta_title = $movie->title;
        $meta_description = $movie->description;
        $meta_image = url('uploads/movie/' . $movie->image);
        if (isset($tap)) {
            $tapphim = $tap;
            $tapphim = substr($tap, 4, 1);
            $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->first();
        } else {
            $tapphim = 1;
            $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->first();
        }
        $tapphim = substr($tap, 4, 20);




        $related = Movie::with('genre')->where('category_id', $movie->category_id)->orderBy(DB::raw('RAND()'))->whereNotIn('slug', [$slug])->get();

        $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->first();
        $episode_order = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode', 'ASC')->get();
        $server = LinkMovie::orderBy('id', 'DESC')->get();
        $episode_movie = Episode::where('movie_id', $movie->id)->orderBy('episode', 'ASC')->get()->unique('server');
        $episode_list = Episode::where('movie_id', $movie->id)->orderBy('episode', 'ASC')->get();
        return view('page.watch', compact('movie',  'episode', 'tapphim', 'related', 'episode_order', 'meta_title', 'meta_description', 'meta_image', 'server', 'episode_movie', 'episode_list', 'server_active')); // gọi file resources/views/page/watch.blade.php
    }
    public function episode()
    {
        return view('page.episode'); // gọi file resources/views/page/episode.blade.php
    }
}
