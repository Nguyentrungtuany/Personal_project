@extends('layouts.app')

@section('content')
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#linkmovie">
Thêm ngay
</button>

<!-- Modal -->
<div class="modal fade" id="linkmovie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    {!! Form::open(['route'=>'linkmovie.store','method'=>'POST']) !!}

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm link phim</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
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
            {{-- <div class="card-header bg-primary text-white fw-bold">
                {{ isset($linkmovie) ? 'Cập nhật link' : 'Thêm link mới' }}
            </div> --}}
            <div class="card-body">

                {{-- @if(!isset($linkmovie)) --}}
                    {{-- {!! Form::open(['route'=>'linkmovie.store','method'=>'POST']) !!} --}}
                {{-- @else
                    {!! Form::open(['route'=>['linkmovie.update',$linkmovie->id],'method'=>'PUT']) !!} --}}
                {{-- @endif --}}

                {{-- Title --}}
                <div class="mb-3">
                    {!! Form::label('title', 'Tên link', ['class' => 'form-label fw-semibold']) !!}
                    {!! Form::text('title', isset($linkmovie) ? $linkmovie->title : '', [
                        'class' => 'form-control',
                        'placeholder' => 'Nhập tên link'
                    ]) !!}
                </div>

                {{-- Slug --}}
                {{-- <div class="mb-3">
                    {!! Form::label('slug', 'Slug', ['class' => 'form-label fw-semibold']) !!}
                    {!! Form::text('slug', isset($linkmovie) ? $linkmovie->slug : '', [
                        'class' => 'form-control',
                        'placeholder' => 'Nhập slug link',
                        'id' => 'convert_slug'
                    ]) !!}
                </div> --}}

                {{-- Description --}}
                <div class="mb-3">
                    {!! Form::label('description', 'Mô tả', ['class' => 'form-label fw-semibold']) !!}
                    {!! Form::textarea('description', isset($linkmovie) ? $linkmovie->description : '', [
                        'rows' => 4,
                        'class' => 'form-control',
                        'placeholder' => 'Nhập mô tả link',
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
                    {{-- @if(!isset($linkmovie))
                        {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-success px-4']) !!}
                    @else
                        {!! Form::submit('Cập nhật', ['class' => 'btn btn-primary px-4']) !!}
                    @endif --}}
                </div>

                {{-- {!! Form::close() !!} --}}
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

</div><div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Danh sách link</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Quản lý</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $key => $cate)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $cate->title }}</td>
                        <td>{{ $cate->description }}</td>
                        <td>
                            @if($cate->status)
                                <span class="badge bg-success">Hiển thị</span>
                            @else
                                <span class="badge bg-danger">Ẩn</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                {!! Form::open(['method'=>'DELETE','route'=>['linkmovie.destroy',$cate->id],'onsubmit'=>'return confirm("Xóa link này?")']) !!}
                                    {!! Form::submit('Xóa', ['class'=>'btn btn-sm btn-danger']) !!}
                                {!! Form::close() !!}
                                <a href="{{ route('linkmovie.edit',$cate->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>    

@endsection
