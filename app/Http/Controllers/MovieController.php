<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Movie_Genre;
use PhpParser\Node\Expr\AssignOp\Mod;
use Carbon\Carbon;
// use Faker\Core\File;
use Illuminate\Support\Facades\File;
class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Movie::with('category', 'movie_genre', 'country','genre')->withCount('episode')->orderBy('id', 'DESC')->get();

        $path = public_path('/json/');
        if(!is_dir($path)){
            mkdir($path,0777,true);
        }
        File::put($path.'movies.json', json_encode($list));
        return view('admincp.movie.index', compact('list')); // gọi file resources/views/admincp/movie/from.blade.php
    }
    public function update_year(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();
    }
    public function update_season(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        $movie->save();
    }
    public function update_topview(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['topview'];
        $movie->save();
    }

    public function filter_topview(Request $request)
    {
        $data = $request->all();
        $movie = Movie::where('topview', $data['value'])->orderBy('ngaycapnhap', 'DESC')->take(40)->get();
        $output = '';
        foreach ($movie as $key => $mov) {
            if ($mov->resolution == 0) {
                $text = 'HD';
            } elseif ($mov->resolution == 1) {
                $text = 'SD';
            } elseif ($mov->resolution == 2) {
                $text = 'HDCam';
            } elseif ($mov->resolution == 3) {
                $text = 'Cam';
            } elseif ($mov->resolution == 4) {
                $text = 'FullHD';
            } else {
                $text = 'Trailer';
            }

            $output .= ' <div class="item post-37176">
                              <a href="' . url('phim/' . $mov->slug) . '" title="' . $mov->title . '">
                                 <div class="item-link">
                                    <img src="' . url('uploads/movie/' . $mov->image) . '" class="lazy post-thumb" alt="' . $mov->title . '" title="' . $mov->title . '" />
                                    <span class="is_trailer">' . $text . '</span>
                                 </div>
                                 <p class="title">' . $mov->title . '</p>
                              </a>
                              <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                              <div style="float: left;">
                                 <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
                                 <span style="width: 0%"></span>
                                 </span>
                              </div>
                           </div> ';
        }
        echo $output;
    }
    public function filter_default(Request $request)
    {
        $data = $request->all();
        $movie = Movie::where('topview', 0)->orderBy('ngaycapnhap', 'DESC')->take(40)->get();
        $output = '';
        foreach ($movie as $key => $mov) {
            if ($mov->resolution == 0) {
                $text = 'HD';
            } elseif ($mov->resolution == 1) {
                $text = 'SD';
            } elseif ($mov->resolution == 2) {
                $text = 'HDCam';
            } elseif ($mov->resolution == 3) {
                $text = 'Cam';
            } elseif ($mov->resolution == 4) {
                $text = 'FullHD';
            } else {
                $text = 'Trailer';
            }

            $output .= ' <div class="item post-37176">
                              <a href="' . url('phim/' . $mov->slug) . '" title="' . $mov->title . '">
                                 <div class="item-link">
                                    <img src="' . url('uploads/movie/' . $mov->image) . '" class="lazy post-thumb" alt="' . $mov->title . '" title="' . $mov->title . '" />
                                    <span class="is_trailer">' . $text . '</span>
                                 </div>
                                 <p class="title">' . $mov->title . '</p>
                              </a>
                              <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                              <div style="float: left;">
                                 <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
                                 <span style="width: 0%"></span>
                                 </span>
                              </div>
                           </div> ';
        }
        echo $output;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $list_genre = Genre::all();
        $country = Country::pluck('title', 'id');
        $movie = null;
        return view('admincp.movie.from', compact('category', 'genre', 'country', 'movie', 'list_genre')); // gọi file resources/views/admincp/movie/from.blade.php
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->tags = $data['tags'];
        $movie->trailer = $data['trailer'];
        $movie->sotap = $data['sotap'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->resolution = $data['resolution'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->name_eng = $data['name_eng'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->thuocphim = $data['thuocphim'];

        $movie->country_id = $data['country_id'];
        $movie->ngaytao = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->ngaycapnhap = Carbon::now('Asia/Ho_Chi_Minh');

        foreach($data['genre'] as $key => $gen){
            $movie->genre_id = $gen[0];
        }
        // $movie->genre_id = $data['genre_id'];

        //them hinh anh

        $get_image = $request->file('image');

        // $path = 'public/uploads/movie/';

        //them hinh anh
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/', $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        // Thêm nhiều thể loai phim
        $movie->movie_genre()->attach($data['genre']);
        return redirect()->route('movie.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $country = Country::pluck('title', 'id'); 
        $list_genre = Genre::all();
        $movie = Movie::find($id);
        $movie_genre = $movie->movie_genre;
        return view('admincp.movie.from', compact('category', 'genre', 'country', 'movie', 'list_genre','movie_genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $movie = Movie::find($id);
        $movie->title = $data['title'];
        $movie->trailer = $data['trailer'];
        $movie->sotap = $data['sotap'];
        $movie->name_eng = $data['name_eng'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->resolution = $data['resolution'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->phude = $data['phude'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->thuocphim = $data['thuocphim'];
        // $movie->genre_id = $data['genre_id'];
        $movie->country_id = $data['country_id'];
        $movie->ngaycapnhap = Carbon::now('Asia/Ho_Chi_Minh');
        foreach($data['genre'] as $key => $gen){
            $movie->genre_id = $gen[0];
        }
        //them hinh anh

        $get_image = $request->file('image');

        // $path = 'public/uploads/movie/';

        //them hinh anh
        if ($get_image) {
            //xoa hinh cu neu co
            if (file_exists('uploads/movie/' . $movie->image)) {
                unlink('uploads/movie/' . $movie->image);
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/', $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        $movie->movie_genre()->sync($data['genre']);

        return redirect()->route('movie.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Movie::find($id);
        // xóa ảnh
        if (file_exists('uploads/movie/' . $movie->image)) {
            unlink('uploads/movie/' . $movie->image);
        }
        // xóa phim xóa luôn cả movie_genre
        // Nếu code như $movie_genre thì không cần nối khóa còn nối khóa rồi thì không cần code này 
        $movie_genre = Movie_Genre::whereIn('movie_id',[$movie->id])->delete();
        //xóa tập phim wherein là xóa một mảng
        Episode::whereIn('movie_id',[$movie->id])->delete();

        $movie->delete();
        return redirect()->back();
    }
}
