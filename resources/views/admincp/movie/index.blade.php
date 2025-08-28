<x-app-layout>
    <x-slot name="header">
        <a href="{{route('movie.create')}}" class="text-gray-900 dark:text-gray-100">Thêm phim</a>

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quản lý danh mục') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                {{-- thêm wrapper để bảng rộng full --}}
                <div class="table-responsive">
                    <table class="table table-responsive table-striped table-bordered table-hover align-middle text-center" id="tablephim" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Tập phim</th>
                                <th scope="col">Tổng tập </th>
                                <th scope="col">Tên tiếng anh</th>
                                <th scope="col">Trailer</th>
                                <th scope="col">Số tập</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Description</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Thể loại</th>
                                <th scope="col">Thể loại</th>
                                <th scope="col">Quốc gia</th>
                                <th scope="col">Năm phim</th>
                                <th scope="col">Season</th>
                                <th scope="col">Thời lượng</th>
                                <th scope="col">Định dạng</th>
                                <th scope="col">Phụ đề</th>
                                <th scope="col">Tags phim</th>
                                <th scope="col">Phim hot</th>
                                <th scope="col">Top view</th>
                                <th scope="col">Action/Inactive</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Ngày cập nhật</th>
                                <th scope="col">Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $key => $cate)
                            <tr>
                                <th scope="row">{{ $key+1 }}</th>
                                <td><img width="80px" src="{{ asset('uploads/movie/'.$cate->image) }}" alt=""></td>
                                <td>{{ $cate->title }}</td>
                                <td><a href="{{route('add-episode', $cate->id)}}" class="btn btn-primary btn-sm">Thêm tập</a></td>
                                <td>
                                    {{-- cout ở đây k phải cột mà là hậu tố đếm  --}}
                                    {{$cate->episode_count}}/{{ $cate->sotap }} Tập
                                </td>
                                <td>{{ $cate->name_eng }}</td>
                                <td>{{ $cate->trailer }}</td>
                                <td>{{ $cate->sotap }}</td>
                                <td>{{ $cate->slug }}</td>
                                <td>
                                    <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $cate->description }}
                                    </div>
                                </td>
                                <td>{{ $cate->category->title }}</td>
                                <td>
                                    @if($cate->thuocphim=='phimle')
                                        <span class="badge bg-primary">Phim lẻ</span>
                                    @else
                                        <span class="badge bg-secondary">Phim bộ</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- {{ $cate->genre->title }} --}}
                                     
                                    @foreach($cate->movie_genre as $value)
                                        <span class="badge bg-secondary">{{ $value->title }}</span>
                                    @endforeach
                                
                                </td>
                                <td>{{ $cate->country->title }}</td>
                                <td>
                                    <form method="POST">
                                        @csrf
                                        {!! Form::selectYear('year', 2000, 2022, isset($cate->year) ? $cate->year : '',['class' => 'select-year','id'=>$cate->id,'placeholder'=>'Năm phim']) !!}
                                    </form>
                                </td>
                                <td>
                                    <form method="POST">
                                        @csrf
                                        {!! Form::selectRange('season', 0, 20, isset($cate->season) ? $cate->season : '0',['class' => 'select-season','id'=>$cate->id]) !!}
                                    </form>
                                </td>
                                <td>{{ $cate->thoiluong }}</td>
                                <td>
                                    @if($cate->resolution==0)
                                        <span class="badge bg-primary">HD</span>
                                    @elseif($cate->resolution==1)
                                        <span class="badge bg-secondary">SD</span>
                                    @elseif($cate->resolution==2)
                                        <span class="badge bg-info">HDcam</span>
                                    @elseif($cate->resolution==3)
                                        <span class="badge bg-warning">Cam</span>
                                    @elseif($cate->resolution==4)
                                        <span class="badge bg-warning">FullHD</span>
                                    @else
                                        <span class="badge bg-success">Trailer</span>
                                    @endif
                                </td>
                                <td>
                                    @if($cate->phude==0)
                                        <span class="badge bg-info">Phụ đề</span>
                                    @else
                                        <span class="badge bg-primary">Thuyết minh</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $cate->tags }}
                                    </div>
                                </td>
                                <td>
                                    @if($cate->phim_hot)
                                        <span class="badge bg-success">Có</span>
                                    @else
                                        <span class="badge bg-secondary">Không</span>
                                    @endif
                                </td>
                                <td>{!! Form::Select('topview', ['0' => 'Ngày', '1' => 'Tuần','2' => 'Tháng'], isset($cate->topview) ? $cate->topview : '', ['class' => 'select-topview', 'id'=>$cate->id,'placeholder'=>'view']) !!}</td>
                                <td>
                                    @if($cate->status)
                                        <span class="badge bg-success">Hiển thị</span>
                                    @else
                                        <span class="badge bg-danger">Không hiển thị</span>
                                    @endif
                                </td>
                               
                                <td>{{ $cate->ngaytao }}</td>
                                <td>{{ $cate->ngaycapnhap }}</td>
                                <td class="align-middle">
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

</x-app-layout>