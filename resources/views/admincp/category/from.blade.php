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
            <div class="card-body">

                @if(!isset($category))
                    {!! Form::open(['route'=>'category.store','method'=>'POST']) !!}
                @else
                    {!! Form::open(['route'=>['category.update',$category->id],'method'=>'PUT']) !!}
                @endif

                {{-- Title --}}
                <div class="mb-3">
                    {!! Form::label('title', 'Tên danh mục', ['class' => 'form-label fw-semibold']) !!}
                    {!! Form::text('title', isset($category) ? $category->title : '', [
                        'class' => 'form-control',
                        'placeholder' => 'Nhập tên danh mục',
                        'id' => 'slug',
                        'onkeyup' => 'ChangeToSlug()'
                    ]) !!}
                </div>

                {{-- Slug --}}
                <div class="mb-3">
                    {!! Form::label('slug', 'Slug', ['class' => 'form-label fw-semibold']) !!}
                    {!! Form::text('slug', isset($category) ? $category->slug : '', [
                        'class' => 'form-control',
                        'placeholder' => 'Nhập slug danh mục',
                        'id' => 'convert_slug'
                    ]) !!}
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    {!! Form::label('description', 'Mô tả', ['class' => 'form-label fw-semibold']) !!}
                    {!! Form::textarea('description', isset($category) ? $category->description : '', [
                        'rows' => 4,
                        'class' => 'form-control',
                        'placeholder' => 'Nhập mô tả danh mục',
                        'id' => 'description'
                    ]) !!}
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    {!! Form::label('status', 'Trạng thái', ['class' => 'form-label fw-semibold']) !!}
                    {!! Form::select('status', ['1' => 'Hiển thị', '0' => 'Không hiển thị'], isset($category) ? $category->status : '', [
                        'class' => 'form-select',
                    ]) !!}
                </div>

                {{-- Submit --}}
                <div class="mt-4">
                    @if(!isset($category))
                        {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-success px-4']) !!}
                    @else
                        {!! Form::submit('Cập nhật', ['class' => 'btn btn-primary px-4']) !!}
                    @endif
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
