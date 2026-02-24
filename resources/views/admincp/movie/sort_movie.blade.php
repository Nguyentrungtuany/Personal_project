@extends('layouts.app')

@section('content')
<div class="container mt-4">

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

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            {{ isset($category) ? 'Cập nhật danh mục' : 'Thêm danh mục mới' }}
        </div>
        <style>
            .ui-state-highlight {
                height: 1.5em;
                line-height: 1.2em;
            }

            ul#sortable_navbar li {
                margin: 0 5px;
            }

            .tieude_phim {
                font-weight: bold;
                color: blue;
                font-size: 16px;
                text-transform: uppercase;
            }

            .box_phim {
                /* height: 200px; */
                border: 2px solid #d1d1d1;
                margin: 3px;
                font-size: 12px;
                padding: 5px;
                text-align: center;
                background-color: blanchedalmond;
            }
        </style>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">

                <ul class="nav navbar-nav flex-row category_position" id="sortable_navbar">
                    {{-- <li class="active">
                        <a target="_blank" href="{{ url('/') }}">Trang chủ</a>
                    </li> --}}

                    @foreach($category as $key => $cate)
                    <li id="{{ $cate->id }}" class="ui-state-default">
                        <a title="{{ $cate->title }}" href="{{ route('category', $cate->slug) }}">
                            {{ $cate->title }}
                        </a>
                    </li>
                    @endforeach

                </ul>

            </div>

        </nav>
        @foreach($Category_home as $key => $cate_home)
        <p class="tieude_phim">{{ $cate_home->title }}</p>
        <div class="row movie_position sortable_movie" id="">
            @foreach($cate_home->movie->sortBy('position')->take(16) as $key => $mov)


            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 box_phim" id="{{ $mov->id }}">
                <figure><img class="img-responsive" width="100%" src="{{ asset('uploads/movie/'.$mov->image) }}"
                        alt="{{ $mov->title }}" title="{{ $mov->title }}"></figure>
                <p class="entry-title">{{ $mov->title }}</p>
            </div>
            @endforeach
            @endforeach
        </div>
    </div>
</div>
</div>
@endsection