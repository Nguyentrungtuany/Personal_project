<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\LinkMovie;
use Carbon\Carbon;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list_episode = Episode::with('movie')->orderBy('movie_id','DESC')->get();
        return view('admincp.episode.index', compact('list_episode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $list_movie = Movie::orderBy('id','DESC')->pluck('title', 'id','thuocphim');
        return view('admincp.episode.from', compact('list_movie'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $episode_check = Episode::where('episode',$data['episode'])->where('movie_id',$data['movie_id'])->count();
        if($episode_check>0){
            
        }else{
        $ep = new Episode();
        $ep->movie_id = $data['movie_id'];
        $ep->linkphim = $data['link'];
        $ep->server = $data['linkserver'];
        $ep->episode = $data['episode'];
        $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $ep->save();
    }
        return redirect()->back();
    }

    public function add_episode($id)
    {
        $linkmovie = LinkMovie::orderBy('id','DESC')->pluck('title','id');
        $list_server = LinkMovie::orderBy('id','DESC')->get();
        $movie = Movie::find($id);
        $list_episode = Episode::with('movie')->where('movie_id', $id)->orderBy('episode','DESC')->get();
        return view('admincp.episode.add_episode', compact('list_episode', 'movie', 'linkmovie', 'list_server'));
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
        $episode = Episode::find($id);
        $linkmovie = LinkMovie::orderBy('id','DESC')->pluck('title','id');
        $list_movie = Movie::orderBy('id','DESC')->pluck('title', 'id');
        return view('admincp.episode.from', compact('episode', 'list_movie', 'linkmovie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $ep =  Episode::find($id);
        $ep->movie_id = $data['movie_id'];
        $ep->linkphim = $data['link'];
        $ep->server = $data['linkserver'];
        $ep->episode = $data['episode'];
        $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $ep->save();

        return redirect()->to('add-episode/'.$ep->movie_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $episode = Episode::find($id);
        $episode->delete();
        return redirect()->to(route('episode.index'));
    }
    public function select_movie()
    {
        $id = $_GET['id'];
       $movie = Movie::find($id);
       $output = ' <option value="">---Chọn tập phim---</option>';
       if($movie->thuocphim=='phimbo'){
           for ($i = 1; $i <= $movie->sotap; $i++) {
               $output .= '<option value="'.$i.'">Tập '.$i.'</option>';
           }
       }else{
           $output .= '<option value="FullHD">FullHD</option>
           <option value="HD">HD</option>
           <option value="4K">4K</option>
           <option value="FullHD">FullHD</option>
           <option value="Cam">Cam</option>
           <option value="HDCam">HDCam</option>';
       }
       echo $output;
    }
}
