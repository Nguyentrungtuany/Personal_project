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
                {{ isset($linkmovie) ? 'Cập nhật link phim' : 'Thêm link phim mới' }}
            </div>
            <div class="card-body">

                @if(!isset($linkmovie))
                    {!! Form::open(['route'=>'linkmovie.store','method'=>'POST']) !!}
                @else
                    {!! Form::open(['route'=>['linkmovie.update',$linkmovie->id],'method'=>'PUT']) !!}
                @endif

                {{-- Title --}}
                <div class="mb-3">
                    {!! Form::label('title', 'Tên link movie', ['class' => 'form-label fw-semibold']) !!}
                    {!! Form::text('title', isset($linkmovie) ? $linkmovie->title : '', [
                        'class' => 'form-control',
                        'placeholder' => 'Nhập tên link movie',
                        
                    ]) !!}
                </div>

                {{-- Slug --}}
                {{-- <div class="mb-3">
                    {!! Form::label('slug', 'Slug', ['class' => 'form-label fw-semibold']) !!}
                    {!! Form::text('slug', isset($linkmovie) ? $linkmovie->slug : '', [
                        'class' => 'form-control',
                        'placeholder' => 'Nhập slug link movie',
                        'id' => 'convert_slug'
                    ]) !!}
                </div> --}}

                {{-- Description --}}
                <div class="mb-3">
                    {!! Form::label('description', 'Mô tả', ['class' => 'form-label fw-semibold']) !!}
                    {!! Form::textarea('description', isset($linkmovie) ? $linkmovie->description : '', [
                        'rows' => 4,
                        'class' => 'form-control',
                        'placeholder' => 'Nhập mô tả link movie',
                        'id' => 'description'
                    ]) !!}
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    {!! Form::label('status', 'Trạng thái', ['class' => 'form-label fw-semibold']) !!}
                    {!! Form::select('status', ['1' => 'Hiển thị', '0' => 'Không hiển thị'], isset($linkmovie) ? $linkmovie->status : '', [
                        'class' => 'form-select',
                    ]) !!}
                </div>

                {{-- Submit --}}
                <div class="mt-4">
                    @if(!isset($linkmovie))
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
