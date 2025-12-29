<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
class InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $info = Info::find(1);  
        return view('admincp.info.from', compact('info'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $data = $request->all();
        $data = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required|max:255',
        'copyright' => 'required|max:255',
        'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
    ],
    [
        'title.required' => 'Tiêu đề không được để trống',
        'description.required' => 'Mô tả không được để trống',
        'copyright.required' => 'Copyright không được để trống',
    ]
);
        $info = Info::find($id);
        $info->title = $data['title'];
        $info->description = $data['description'];
        $info->copyright = $data['copyright'];
        $get_image = $request->file('image');

        // $path = 'public/uploads/movie/';

        //them hinh anh
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/logo/', $new_image);
            $info->logo = $new_image;
        }
        $info->save();
        toastr()->success('Cập nhật thông tin website thành công!', ['title' => 'Cập nhật']);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
