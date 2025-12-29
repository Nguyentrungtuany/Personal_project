@extends('layouts.app')

@section('content')

<div class="modal" id="videoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" ><span id="video_title"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="video_desc"></p>
                <p id="video_link"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>

</div>

<div class="container-fluid">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle text-center" id="tablephim" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Tập phim</th>
                            <th>Tổng tập</th>
                            <th>Tên tiếng anh</th>
                            <th>Trailer</th>
                            <th>Số tập</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Danh mục</th>
                            <th>Thuộc phim</th>
                            <th>Thể loại</th>
                            <th>Quốc gia</th>
                            <th>Năm phim</th>
                            <th>Season</th>
                            <th>Thời lượng</th>
                            <th>Định dạng</th>
                            <th>Phụ đề</th>
                            <th>Tags phim</th>
                            <th>Phim hot</th>
                            <th>Top view</th>
                            <th>Action/Inactive</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $key => $cate)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                <img width="80px" src="{{ asset('uploads/movie/'.$cate->image) }}" alt="">
                                <input type="file" data-movie_id="{{$cate->id}}" id="file-{{$cate->id}}" class="form-control-file file_image" accept="image/*">
                                <span id="error_image"></span>
                            </td>
                            <td>{{ $cate->title }}</td>
                            <td>
                                <a href="{{route('add-episode', $cate->id)}}" class="btn btn-primary btn-sm">Thêm tập</a>
                                @foreach($cate->episode as $key => $epis)
                                    {{-- <span class="badge bg-dark"><a href="{{route('episode.edit', $epis->id)}}" style="color: white">Tập {{ $key+1 }}</a></span> --}}
                                    <a class="show_video" 
                                    data-movie_video_id="{{$epis->movie_id}}" 
                                    data-video_episode="{{$epis->episode}}" 
                                    style="color: white;cursor: pointer" >
                                        <span class="badge badge-dark">{{ $epis->episode }}</span>
                                    </a>
                                @endforeach

                            </td>
                            <td>{{ $cate->episode_count }}/{{ $cate->sotap }} Tập</td>
                            <td>{{ $cate->name_eng }}</td>
                            <td>{{ $cate->trailer }}</td>
                            <td>{{ $cate->sotap }}</td>
                            <td>{{ $cate->slug }}</td>
                            <td>
                                <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $cate->description }}
                                </div>
                            </td>
                            <td>
                                {!! Form::Select('category_id',$category, isset($cate) ? $cate->category->id : '', [
                                    'class' => 'form-select category_choose',
                                    'id'=>$cate->id
                                ]) !!}
                            </td>
                            <td>
                                <select id="{{$cate->id}}" class="thuocphim_choose">
                                    <option value="phimle" {{ $cate->thuocphim=='phimle'?'selected':'' }}>Phim lẻ</option>
                                    <option value="phimbo" {{ $cate->thuocphim=='phimbo'?'selected':'' }}>Phim bộ</option>
                                </select>
                            </td>
                            <td>
                                @foreach($cate->movie_genre as $value)
                                    <span class="badge bg-secondary">{{ $value->title }}</span>
                                @endforeach
                            </td>
                            <td>
                                {!! Form::Select('country_id',$country, isset($cate) ? $cate->country->id : '', [
                                    'class' => 'form-select country_choose',
                                    'id'=>$cate->id
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::selectYear('year', 2000, now()->year, isset($cate->year) ? $cate->year : '',[
                                    'class' => 'form-select select-year',
                                    'id'=>$cate->id
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::selectRange('season', 0, 20, isset($cate->season) ? $cate->season : '0',[
                                    'class' => 'form-select select-season',
                                    'id'=>$cate->id
                                ]) !!}
                            </td>
                            <td>{{ $cate->thoiluong }}</td>
                            <td>
                                @php
                                    $options = [
                                        '0' => 'HD',
                                        '1' => 'SD',
                                        '2' => 'HDcam',
                                        '3' => 'Cam',
                                        '4' => 'FullHD',
                                        '5' => 'Trailer'
                                    ];
                                @endphp
                                <select id="{{$cate->id}}" class="resolution_choose">
                                    @foreach($options as $k => $resolution)
                                        <option value="{{ $k }}" {{ $cate->resolution == $k ? 'selected' : '' }}>{{ $resolution }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select id="{{$cate->id}}" class="phude_choose">
                                    <option value="0" {{ $cate->phude==0 ? 'selected':'' }}>Phụ đề</option>
                                    <option value="1" {{ $cate->phude==1 ? 'selected':'' }}>Thuyết minh</option>
                                </select>
                            </td>
                            <td>
                                <div style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $cate->tags }}
                                </div>
                            </td>
                            <td>
                                <select id="{{$cate->id}}" class="phimhot_choose">
                                    <option value="0" {{ $cate->phim_hot==0 ? 'selected':'' }}>Không</option>
                                    <option value="1" {{ $cate->phim_hot==1 ? 'selected':'' }}>Có</option>
                                </select>
                            </td>
                            <td>
                                {!! Form::Select('topview', ['0' => 'Ngày', '1' => 'Tuần','2' => 'Tháng'], isset($cate->topview) ? $cate->topview : '', [
                                    'class' => 'form-select select-topview',
                                    'id'=>$cate->id,
                                    'placeholder'=>'view'
                                ]) !!}
                            </td>
                            <td>
                                <select id="{{$cate->id}}" class="trangthai_choose">
                                    <option value="0" {{ $cate->status==0 ? 'selected':'' }}>Không</option>
                                    <option value="1" {{ $cate->status==1 ? 'selected':'' }}>Hiển thị</option>
                                </select>
                            </td>
                            <td>{{ $cate->ngaytao }}</td>
                            <td>{{ $cate->ngaycapnhap }}</td>
                            <td>
                                <div class="d-flex flex-column gap-2 align-items-center justify-content-center py-2">
                                    <a href="{{ route('movie.edit', $cate->id) }}" class="btn btn-warning btn-sm w-100 fw-semibold text-dark">Sửa</a>
                                    {!! Form::open(['method'=>'DELETE','route' => ['movie.destroy', $cate->id],'onsubmit' => 'return confirm("Xóa hay ko?")']) !!}
                                        {!! Form::submit('Xóa', ['class' => 'btn btn-danger btn-sm w-100 fw-semibold']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
