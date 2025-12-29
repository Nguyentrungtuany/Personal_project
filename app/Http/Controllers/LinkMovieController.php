<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\LinkMovie;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;

class LinkMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = LinkMovie::all();
        return view('admincp.linkmovie.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admincp.linkmovie.from');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $data = $request->validate([
        'title' => 'required|unique:categories|max:255',
        'description' => 'required|max:255',
        'status' => 'required',
    ],
    [
        'title.unique' => 'Tiêu đề đã tồn tại',
        'title.required' => 'Tiêu đề không được để trống',
        'description.required' => 'Mô tả không được để trống',
        'status.required' => 'Trạng thái không được để trống',
    ]
);

        $linkmovie = new LinkMovie();
        $linkmovie->title = $data['title'];
        $linkmovie->description = $data['description'];
        $linkmovie->status = $data['status'];

        $linkmovie->save();
        toastr()->success('Thêm thành công!');

        return redirect()->route('linkmovie.index');
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
        $linkmovie = LinkMovie::find($id);
        return view('admincp.linkmovie.from', compact('linkmovie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'status' => 'required',
        ],
        [
            'title.required' => 'Tiêu đề không được để trống',
            'description.required' => 'Mô tả không được để trống',
            'status.required' => 'Trạng thái không được để trống',
        ]
        );
        $linkmovie = LinkMovie::find($id);
        $linkmovie->title = $data['title'];
        $linkmovie->description = $data['description'];
        $linkmovie->status = $data['status'];
        $linkmovie->save();
        toastr()->success('Cập nhật thành cong!');
        return redirect()->route('linkmovie.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        LinkMovie::find($id)->delete();
        toastr()->success('Xóa thành công!');
        return redirect()->back();
    }
}
