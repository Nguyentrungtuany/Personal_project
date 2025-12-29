@extends('layouts.app')

@section('content')

<div class="container-fluid my-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Quản lý tập phim</h5>
            <a href="{{ route('episode.create') }}" class="btn btn-success btn-sm">
                + Thêm tập mới
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle text-center mb-0" id="tablephim">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tên phim</th>
                            <th>Ảnh phim</th>
                            <th>Tập phim</th>
                            <th>Link phim</th>
                            <th>Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list_episode as $key => $episode)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td class="fw-semibold">{{ $episode->movie->title }}</td>
                            <td>
                                <img src="{{ asset('uploads/movie/'.$episode->movie->image) }}" 
                                     alt="{{ $episode->movie->title }}" 
                                     width="80" class="img-thumbnail">
                            </td>
                            <td>{{ $episode->episode }}</td>
                            <td class="text-truncate" style="max-width:200px;">
                                {!! $episode->linkphim !!}
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('episode.edit', $episode->id) }}" class="btn btn-warning btn-sm">
                                        Sửa
                                    </a>
                                    {!! Form::open(['method'=>'DELETE','route' => ['episode.destroy', $episode->id],'onsubmit' => 'return confirm("Xóa hay ko?")']) !!}
                                        {!! Form::submit('Xóa', ['class' => 'btn btn-danger btn-sm']) !!}
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
