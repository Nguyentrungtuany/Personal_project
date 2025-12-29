@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4 fw-bold text-primary">
        {{ isset($episode) ? 'Cập nhật tập phim' : 'Thêm tập phim mới' }}
    </h4>

    {{-- FORM --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            @if(isset($episode))
                {!! Form::open(['route'=>['episode.update', $episode->id],'method'=>'PUT']) !!}
            @else
                {!! Form::open(['route'=>'episode.store','method'=>'POST']) !!}
            @endif

            {{-- Tên phim --}}
            <div class="mb-3">
                {!! Form::label('movie_title', 'Tên phim', ['class' => 'form-label fw-semibold']) !!}
                {!! Form::text('movie_title', $movie->title, [
                    'class' => 'form-control',
                    'readonly'
                ]) !!}
                {!! Form::hidden('movie_id', $movie->id) !!}
            </div>

            {{-- Link phim --}}
            <div class="mb-3">
                {!! Form::label('link', 'Đường dẫn phim', ['class' => 'form-label fw-semibold']) !!}
                {!! Form::text('link', isset($episode) ? $episode->linkphim : '', [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập link phim...'
                ]) !!}
            </div>

            {{-- Tập phim --}}
            <div class="mb-3">
                {!! Form::label('episode', 'Tập phim', ['class' => 'form-label fw-semibold']) !!}
                @if(isset($episode))
                    {!! Form::text('episode', $episode->episode, ['class' => 'form-control','readonly']) !!}
                @else
                    {!! Form::selectRange('episode', 1, $movie->sotap, $movie->sotap, ['class'=>'form-select']) !!}
                @endif
            </div>

            {{-- Server phim --}}
            <div class="mb-3">
                {!! Form::label('linkserver', 'Server phim', ['class'=>'form-label fw-semibold']) !!}
                {!! Form::select('linkserver', $linkmovie, '', ['class'=>'form-select']) !!}
            </div>

            {{-- Nút lưu --}}
            <div class="text-end">
                {!! Form::submit(isset($episode) ? 'Cập nhật' : 'Thêm mới', ['class'=>'btn btn-success px-4']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>

    {{-- DANH SÁCH TẬP PHIM --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-semibold">
            Danh sách tập phim
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="50">#</th>
                        <th>Tên phim</th>
                        <th>Tập</th>
                        <th>Server</th>
                        {{-- <th></th> --}}
                        <th>Link phim</th>
                        <th width="150" class="text-center">Quản lý</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list_episode as $key => $epi)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $epi->movie->title }}</td>
                            <td>{{ $epi->episode }}</td>
                            @foreach($list_server as $key => $server_link)
                                @if($epi->server == $server_link->id)
                                    <td>{{ $server_link }}</td>
                                @else
                                    <td></td>
                                @endif
                            @endforeach
                            {{-- <td>{{ $epi->linkmovie->title ?? 'N/A' }}</td> --}}
                            <td>{!! $epi->linkphim !!}</td>
                            <td class="text-center">
                                <a href="{{ route('episode.edit',$epi->id) }}" class="btn btn-sm btn-warning">
                                    Sửa
                                </a>
                                {!! Form::open(['method'=>'DELETE','route'=>['episode.destroy',$epi->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Xóa',['class'=>'btn btn-sm btn-danger','onclick'=>'return confirm("Bạn có chắc muốn xóa tập này?")']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
