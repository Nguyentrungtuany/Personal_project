@extends('layouts.app')

@section('content')

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            {{-- Hiển thị lỗi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form thêm/cập nhật phim --}}
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        {{ isset($movie) ? 'Cập nhật phim' : 'Thêm phim mới' }}
                    </h5>
                </div>
                <div class="card-body">
                    @if(!isset($movie))
                        {!! Form::open(['route'=>'movie.store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
                    @else
                        {!! Form::open(['route'=>['movie.update',$movie->id],'method'=>'PUT','enctype'=>'multipart/form-data']) !!}
                    @endif

                    {{-- Title --}}
                    <div class="mb-3">
                        {!! Form::label('title', 'Tên phim', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::text('title', $movie->title ?? '', [
                            'class'=>'form-control',
                            'placeholder'=>'Nhập tên phim',
                            'id'=>'slug',
                            'onkeyup'=>'ChangeToSlug()'
                        ]) !!}
                    </div>

                    {{-- Thời lượng --}}
                    <div class="mb-3">
                        {!! Form::label('thoiluong', 'Thời lượng', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::text('thoiluong', $movie->thoiluong ?? '', [
                            'class'=>'form-control',
                            'placeholder'=>'Nhập thời lượng phim'
                        ]) !!}
                    </div>

                    {{-- Tên tiếng Anh --}}
                    <div class="mb-3">
                        {!! Form::label('name_eng', 'Tên tiếng Anh', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::text('name_eng', $movie->name_eng ?? '', [
                            'class'=>'form-control',
                            'placeholder'=>'Nhập tên tiếng Anh'
                        ]) !!}
                    </div>

                    {{-- Trailer --}}
                    <div class="mb-3">
                        {!! Form::label('trailer', 'Trailer', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::text('trailer', $movie->trailer ?? '', [
                            'class'=>'form-control',
                            'placeholder'=>'Link trailer'
                        ]) !!}
                    </div>

                    {{-- Số tập --}}
                    <div class="mb-3">
                        {!! Form::label('sotap', 'Số tập phim', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::text('sotap', $movie->sotap ?? '', [
                            'class'=>'form-control',
                            'placeholder'=>'Nhập số tập phim'
                        ]) !!}
                    </div>

                    {{-- Slug --}}
                    <div class="mb-3">
                        {!! Form::label('slug', 'Slug', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::text('slug', $movie->slug ?? '', [
                            'class'=>'form-control',
                            'placeholder'=>'Nhập slug',
                            'id'=>'convert_slug'
                        ]) !!}
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        {!! Form::label('description', 'Mô tả', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::textarea('description', $movie->description ?? '', [
                            'class'=>'form-control',
                            'rows'=>3,
                            'placeholder'=>'Nhập mô tả phim'
                        ]) !!}
                    </div>

                    {{-- Tags --}}
                    <div class="mb-3">
                        {!! Form::label('tags', 'Tags phim', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::textarea('tags', $movie->tags ?? '', [
                            'class'=>'form-control',
                            'rows'=>2,
                            'placeholder'=>'Ví dụ: phim hành động, anime, tâm lý...'
                        ]) !!}
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        {!! Form::label('status', 'Trạng thái', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::select('status', ['1'=>'Hiển thị','0'=>'Không hiển thị'], $movie->status ?? '', [
                            'class'=>'form-select'
                        ]) !!}
                    </div>

                    {{-- Resolution --}}
                    <div class="mb-3">
                        {!! Form::label('resolution', 'Độ phân giải', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::select('resolution', [
                            '0'=>'HD','1'=>'SD','2'=>'HDcam','3'=>'Cam','4'=>'FullHD','5'=>'Trailer'
                        ], $movie->resolution ?? '', ['class'=>'form-select']) !!}
                    </div>

                    {{-- Phụ đề --}}
                    <div class="mb-3">
                        {!! Form::label('phude', 'Ngôn ngữ', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::select('phude', ['0'=>'Phụ đề','1'=>'Thuyết minh'], $movie->phude ?? '', ['class'=>'form-select']) !!}
                    </div>

                    {{-- Category --}}
                    <div class="mb-3">
                        {!! Form::label('category_id', 'Danh mục', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::select('category_id', $category, $movie->category_id ?? '', ['class'=>'form-select']) !!}
                    </div>

                    {{-- Thuộc phim --}}
                    <div class="mb-3">
                        {!! Form::label('thuocphim', 'Loại phim', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::select('thuocphim', ['phimle'=>'Phim lẻ','phimbo'=>'Phim bộ'], $movie->thuocphim ?? '', ['class'=>'form-select']) !!}
                    </div>

                    {{-- Quốc gia --}}
                    <div class="mb-3">
                        {!! Form::label('country_id', 'Quốc gia', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::select('country_id', $country, $movie->country_id ?? '', ['class'=>'form-select']) !!}
                    </div>

                    {{-- Thể loại --}}
                    <div class="mb-3">
                        {!! Form::label('genre', 'Thể loại', ['class'=>'form-label fw-semibold d-block']) !!}
                        @foreach($list_genre as $gen)
                            <div class="form-check form-check-inline">
                                {!! Form::checkbox('genre[]', $gen->id, isset($movie_genre) && $movie_genre->contains($gen->id)) !!}
                                {!! Form::label('genre', $gen->title, ['class'=>'form-check-label']) !!}
                            </div>
                        @endforeach
                    </div>

                    {{-- Hot --}}
                    <div class="mb-3">
                        {!! Form::label('phim_hot', 'Phim hot', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::select('phim_hot', ['1'=>'Có','0'=>'Không'], $movie->phim_hot ?? '', ['class'=>'form-select']) !!}
                    </div>

                    {{-- Ảnh --}}
                    <div class="mb-3">
                        {!! Form::label('image', 'Ảnh phim', ['class'=>'form-label fw-semibold']) !!}
                        {!! Form::file('image', ['class'=>'form-control']) !!}
                        @if(isset($movie) && $movie->image)
                            <img src="{{ asset('uploads/movie/'.$movie->image) }}" alt="" class="mt-2 rounded shadow-sm" width="150">
                        @endif
                    </div>

                    {{-- Submit --}}
                    <div>
                        {!! Form::submit(isset($movie) ? 'Cập nhật' : 'Thêm mới', ['class'=>'btn btn-success']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
