@extends('layouts.app')

@section('content')
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#genre">
Thêm ngay
</button>

<!-- Modal -->
<div class="modal fade" id="genre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    {!! Form::open(['route'=>'genre.store','method'=>'POST']) !!}

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm danh thể loại</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid my-4">
    <div class="row justify-content-center">
        {{-- <div class="col-lg-8">
            <div class="card shadow-sm mb-4"> --}}
                {{-- <div class="card-header bg-dark text-white"> --}}
                    {{-- <h5 class="mb-0">
                        {{ isset($genre) ? 'Cập nhật thể loại' : 'Thêm thể loại mới' }}
                    </h5> --}}
                {{-- </div> --}}
                <div class="card-body">
                    {{-- @if(!isset($genre))
                        {!! Form::open(['route'=>'genre.store','method'=>'POST']) !!}
                    @else
                        {!! Form::open(['route'=>['genre.update',$genre->id],'method'=>'PUT']) !!}
                    @endif --}}

                    {{-- Title --}}
                    <div class="mb-3">
                        {!! Form::label('title', 'Tên thể loại', ['class' => 'form-label fw-semibold']) !!}
                        {!! Form::text('title', isset($genre) ? $genre->title : '', [
                            'class' => 'form-control',
                            'placeholder' => 'Nhập tên danh mục',
                            'id' => 'slug','onkeyup' => 'ChangeToSlug()'
                        ]) !!}
                    </div>

                    {{-- Slug --}}
                    <div class="mb-3">
                        {!! Form::label('slug', 'Slug', ['class' => 'form-label fw-semibold']) !!}
                        {!! Form::text('slug', isset($genre) ? $genre->slug : '', [
                            'class' => 'form-control',
                            'placeholder' => 'Nhập slug danh mục',
                            'id' => 'convert_slug'
                        ]) !!}
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        {!! Form::label('description', 'Mô tả', ['class' => 'form-label fw-semibold']) !!}
                        {!! Form::textarea('description', isset($genre) ? $genre->description : '', [
                            'rows' => 4,
                            'class' => 'form-control',
                            'placeholder' => 'Nhập mô tả danh mục',
                            'id' => 'description'
                        ]) !!}
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        {!! Form::label('status', 'Trạng thái', ['class' => 'form-label fw-semibold']) !!}
                        {!! Form::select('status', ['1' => 'Hiển thị', '0' => 'Không hiển thị'], isset($genre) ? $genre->status : '', [
                            'class' => 'form-select'
                        ]) !!}
                    </div>

                    {{-- Submit --}}
                    {{-- <div>
                        {!! Form::submit(isset($genre) ? 'Cập nhật' : 'Thêm mới', [
                            'class' => 'btn btn-success'
                        ]) !!}
                    </div> --}}

                    {{-- {!! Form::close() !!} --}}
                {{-- </div>
            </div> --}}
        </div>
    </div>

</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-primary px-4']) !!}
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>
{{-- Table --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Danh sách thể loại</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle text-center mb-0" id="tablephim">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tiêu đề</th>
                            <th>Slug</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $key => $cate)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td class="fw-semibold">{{ $cate->title }}</td>
                            <td>{{ $cate->slug }}</td>
                            <td>{{ $cate->description }}</td>
                            <td>
                                @if($cate->status)
                                    <span class="badge bg-success">Hiển thị</span>
                                @else
                                    <span class="badge bg-danger">Không hiển thị</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('genre.edit', $cate->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                    {!! Form::open(['method'=>'DELETE','route' => ['genre.destroy', $cate->id],'onsubmit' => 'return confirm("Xóa hay không?")']) !!}
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
@endsection