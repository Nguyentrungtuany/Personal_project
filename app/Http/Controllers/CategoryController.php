<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Category::orderBy('position', 'ASC')->get();
        return view('admincp.category.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admincp.category.from');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $data = $request->all();
        $data = $request->validate([
        'title' => 'required|unique:categories|max:255',
        'slug' => 'required|unique:categories|max:255',
        'description' => 'required|max:255',
        'status' => 'required',
    ],
    [
        'title.unique' => 'Tiêu đề đã tồn tại',
        'title.required' => 'Tiêu đề không được để trống',
        'slug.required' => 'Slug không được để trống',
        'slug.unique' => 'Slug đã tồn tại',
        'description.required' => 'Mô tả không được để trống',
        'status.required' => 'Trạng thái không được để trống',
    ]
);
        $maxPosition = Category::max('position') ?? 0;

        $category = new Category();
        $category->title = $data['title'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];
        $category->status = $data['status'];
        $category->position = $maxPosition + 1; 

        $category->save();
        toastr()->success('Thêm thành công!');

        return redirect()->route('category.index');
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
        $category = Category::find($id);
        $list = Category::orderBy('position', 'ASC')->get();
        return view('admincp.category.from', compact('list', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $category =  Category::find($id);
        $category->slug = $data['slug'];
        $category->description = $data['description'];
        $category->status = $data['status'];
        $category->save();

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::find($id)->delete();
        return redirect()->back();
    }

    public function resorting(Request $request)
    {
        $data = $request->all();

        foreach($data['array_id'] as $key => $value) {
            $category = Category::find($value);
            $category->position = $key;
            $category->save();
        }

        // return redirect()->back();
    }
}