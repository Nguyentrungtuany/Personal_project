@extends('layouts.app')

@section('content')

<div class="container my-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            {{ isset($episode) ? 'Cập nhật tập phim' : 'Thêm tập phim mới' }}
        </div>
        <div class="card-body">

            @if(!isset($episode))
                {!! Form::open(['route'=>'episode.store','method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
            @else
                {!! Form::open(['route'=>['episode.update',$episode->id],'method'=>'PUT', 'enctype'=>'multipart/form-data']) !!}
            @endif

            {{-- Chọn phim --}}
            <div class="mb-3">
                {!! Form::label('movie', 'Chọn phim', ['class' => 'form-label fw-semibold']) !!}
                {!! Form::select(
                    'movie_id',
                    ['0' => 'Chọn phim', 'Danh sách phim' => $list_movie],
                    isset($episode) ? $episode->movie_id : '',
                    ['class' => 'form-select']
                ) !!}
            </div>

            {{-- Link phim --}}
            <div class="mb-3">
                {!! Form::label('link', 'Link phim', ['class' => 'form-label fw-semibold']) !!}
                {!! Form::text('link', isset($episode) ? $episode->linkphim : '', [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập link phim',
                ]) !!}
            </div>

            {{-- Tập phim --}}
            @if(isset($episode))
                <div class="mb-3">
                    {!! Form::label('episode', 'Tập phim', ['class' => 'form-label fw-semibold']) !!}
                    {!! Form::text('episode', $episode->episode, [
                        'class' => 'form-control',
                        'readonly' => true,
                    ]) !!}
                </div>
            @else
                
                <div class="mb-3">
                    {!! Form::label('episode', 'Tập phim', ['class' => 'form-label fw-semibold']) !!}
                    <select name="episode" id="show_movie" class="form-select"></select>
                </div>
            @endif
                <div class="mb-3">
                    {!! Form::label('linkserver', 'Link server', ['class' => 'form-label fw-semibold']) !!}
                    {!! Form::select('linkserver', $linkmovie, $episode->server, ['class' => 'form-select']) !!}
                </div>
            {{-- Submit --}}
            <div class="mt-3">
                @if(!isset($episode))
                    {!! Form::submit('Thêm tập phim', ['class' => 'btn btn-success px-4']) !!}
                @else
                    {!! Form::submit('Cập nhật tập phim', ['class' => 'btn btn-primary px-4']) !!}
                @endif
            </div>

            {!! Form::close() !!}
        </div>
    </div>

</div>

@endsection
