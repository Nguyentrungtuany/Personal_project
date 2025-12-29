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
use PHPUnit\Framework\Constraint\Count;
use SebastianBergmann\LinesOfCode\Counter;

use function Pest\Laravel\json;

class MovieController extends Controller
{
    public function update_image_movie_ajax(Request $request)
{
    try {
        $get_image = $request->file('file');
        $movie_id = $request->movie_id;

        if ($get_image) {
            $movie = Movie::find($movie_id);

            // Xóa ảnh cũ
            if ($movie->image && file_exists(public_path('uploads/movie/'.$movie->image))) {
                unlink(public_path('uploads/movie/'.$movie->image));
            }

            // Tạo tên mới
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = pathinfo($get_name_image, PATHINFO_FILENAME);
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();

            // Upload
            $get_image->move(public_path('uploads/movie/'), $new_image);

            // Cập nhật DB
            $movie->image = $new_image;
            $movie->save();
        }

        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function resolution_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->resolution = $data['resolution_id'];
        $movie->save();

    }
    public function phude_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->phude = $data['phude_id'];
        $movie->save();

    }
    public function phimhot_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->phim_hot = $data['phimhot_id'];
        $movie->save();

    }
    public function thuocphim_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->thuocphim = $data['thuocphim_id'];
        $movie->save();

    }
    public function trangthai_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->status = $data['trangthai_id'];
        $movie->save();

    }
    public function country_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->country_id = $data['country_id'];
        $movie->save();

    }
    public function category_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->category_id = $data['category_id'];
        $movie->save();

    }
    public function index()
    {
        $list = Movie::with('category', 'movie_genre', 'country','genre')->withCount('episode')->orderBy('id', 'DESC')->get();
        $category = Category::pluck('title', 'id');
        $country = Country::pluck('title', 'id');
        $path = public_path('/json/');
        if(!is_dir($path)){
            mkdir($path,0777,true);
        }
        File::put($path.'movies.json', json_encode($list));
        return view('admincp.movie.index', compact('list', 'category','country')); // gọi file resources/views/admincp/movie/from.blade.php
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
            if ($mov->count_views > 0) {
                $viewCount = number_format($mov->count_views);
            } else {
                $viewCount = rand(100, 99999);
            }
            $output .= ' <div class="item post-37176">
                              <a href="' . url('phim/' . $mov->slug) . '" title="' . $mov->title . '">
                                 <div class="item-link">
                                    <img src="' . url('uploads/movie/' . $mov->image) . '" class="lazy post-thumb" alt="' . $mov->title . '" title="' . $mov->title . '" />
                                    <span class="is_trailer">' . $text . '</span>
                                 </div>
                                 <p class="title">' . $mov->title . '</p>
                              </a>
                              <div class="viewsCount" style="color: #9d9d9d;">' . $viewCount . ' lượt xem</div>
                              <div class="viewsCount" style="color: #9d9d9d;">' . $mov->year . '</div>

                        <div style="float: left;">
                            <ul class="list-inline rating" title="Average Rating">
                            ';
                                for($count = 1; $count <= 5; $count++){
                                   $output .= '<li title="star_rating" style="font-size: 20px; color: #ffcc00; padding: 0">&#9733;</li>';
                            }

                            $output .= '<ul class="list-inline-rating" title="Average Rating">
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
            if ($mov->count_views > 0) {
                $viewCount = number_format($mov->count_views);
            } else {
                $viewCount = rand(100, 99999);
            }
            $output .= ' <div class="item post-37176">
                              <a href="' . url('phim/' . $mov->slug) . '" title="' . $mov->title . '">
                                 <div class="item-link">
                                    <img src="' . url('uploads/movie/' . $mov->image) . '" class="lazy post-thumb" alt="' . $mov->title . '" title="' . $mov->title . '" />
                                    <span class="is_trailer">' . $text . '</span>
                                 </div>
                                 <p class="title">' . $mov->title . '</p>
                              </a>
                              <div class="viewsCount" style="color: #9d9d9d;">' . $viewCount . ' lượt xem</div>
                              <div class="viewsCount" style="color: #9d9d9d;">' . $mov->year . '</div>

                        <div style="float: left;">
                            <ul class="list-inline rating" title="Average Rating">
                            ';
                                for($count = 1; $count <= 5; $count++){
                                   $output .= '<li title="star_rating" style="font-size: 20px; color: #ffcc00; padding: 0">&#9733;</li>';
                            }

                            $output .= '<ul class="list-inline-rating" title="Average Rating">
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
//         $data = $request->validate([
//     'title' => 'required|unique:categories|max:500',
//     'slug' => 'required|unique:categories|max:500',
//     'description' => 'required|max:500',
//     'hinhanh' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
//     'status' => 'required',
// ], [
//     // Messages cho title
//     'title.required' => 'Tiêu đề không được để trống',
//     'title.unique' => 'Tiêu đề đã tồn tại',
//     'title.max' => 'Tiêu đề không được vượt quá 500 ký tự',
    
//     // Messages cho slug
//     'slug.required' => 'Slug không được để trống',
//     'slug.unique' => 'Slug đã tồn tại',
//     'slug.max' => 'Slug không được vượt quá 500 ký tự',
    
//     // Messages cho description
//     'description.required' => 'Mô tả không được để trống',
//     'description.max' => 'Mô tả không được vượt quá 500 ký tự',
    
//     // Messages cho hinhanh
//     'hinhanh.required' => 'Hình ảnh không được để trống',
//     'hinhanh.image' => 'File phải là hình ảnh',
//     'hinhanh.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg',
//     'hinhanh.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
//     'hinhanh.dimensions' => 'Kích thước hình ảnh phải từ 100x100px đến 2000x2000px',
    
//     // Messages cho status
//     'status.required' => 'Trạng thái không được để trống',
// ]);
        $data = $request->all();
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->tags = $data['tags'];
        $movie->trailer = $data['trailer'];
        $movie->sotap = $data['sotap'];
        $movie->count_views = rand(100,99999);
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
        // $movie->count_views = rand(100,99999);
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
    public function watch_video(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $video = Episode::where('movie_id',$data['movie_id'])->where('episode',$data['episode_id'])->first();
        $output['video_title'] = $movie->title.' - Tập '.$video->episode;
        $output['video_desc'] = $movie->description;
        $output['video_link'] = $video->linkphim;
        return json_encode($output);
    }

}
