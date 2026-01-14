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
        </style>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">

                <ul class="nav navbar-nav category_position" id="sortable_navbar">
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
    </div>
</div>
</div>
@endsection