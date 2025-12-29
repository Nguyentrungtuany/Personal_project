@extends('layouts.app')

@section('content')
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#country">
Thêm ngay
</button>

<!-- Modal -->
<div class="modal fade" id="country" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    {!! Form::open(['route'=>'country.store','method'=>'POST']) !!}

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm danh quốc gia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container my-4">

    {{-- Hiển thị form --}}
    <div class="card shadow-sm mb-4">
        {{-- <div class="card-header bg-primary text-white fw-bold">
            {{ isset($country) ? 'Cập nhật quốc gia' : 'Thêm quốc gia mới' }}
        </div> --}}
        <div class="card-body">
            {{-- @if(!isset($country))
                {!! Form::open(['route'=>'country.store','method'=>'POST']) !!}
            @else
                {!! Form::open(['route'=>['country.update',$country->id],'method'=>'PUT']) !!}
            @endif --}}

            {{-- Title --}}
            <div class="mb-3">
                {!! Form::label('title', 'Tên quốc gia', ['class' => 'form-label fw-semibold']) !!}
                {!! Form::text('title', isset($country) ? $country->title : '', [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập tên quốc gia',
                    'id' => 'slug',
                    'onkeyup' => 'ChangeToSlug()'
                ]) !!}
            </div>

            {{-- Slug --}}
            <div class="mb-3">
                {!! Form::label('slug', 'Slug', ['class' => 'form-label fw-semibold']) !!}
                {!! Form::text('slug', isset($country) ? $country->slug : '', [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập slug quốc gia',
                    'id' => 'convert_slug'
                ]) !!}
            </div>

            {{-- Description --}}
            <div class="mb-3">
                {!! Form::label('description', 'Mô tả', ['class' => 'form-label fw-semibold']) !!}
                {!! Form::textarea('description', isset($country) ? $country->description : '', [
                    'rows' => 4,
                    'class' => 'form-control',
                    'placeholder' => 'Nhập mô tả quốc gia',
                    'id' => 'description'
                ]) !!}
            </div>

            {{-- Status --}}
            <div class="mb-3">
                {!! Form::label('status', 'Trạng thái', ['class' => 'form-label fw-semibold']) !!}
                {!! Form::select('status', ['1' => 'Hiển thị', '0' => 'Không hiển thị'], isset($country) ? $country->status : '', [
                    'class' => 'form-select',
                ]) !!}
            </div>

            {{-- Submit --}}
            {{-- <div class="mt-3">
                @if(!isset($country))
                    {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-success px-4']) !!}
                @else
                    {!! Form::submit('Cập nhật', ['class' => 'btn btn-primary px-4']) !!}
                @endif
            </div> --}}

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
 <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-bold">
            Danh sách quốc gia
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered table-hover align-middle text-center mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tên quốc gia</th>
                        <th>Slug</th>
                        <th>Mô tả</th>
                        <th>Trạng thái</th>
                        <th>Quản lý</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $key => $cate)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>{{ $cate->title }}</td>
                        <td>{{ $cate->slug }}</td>
                        <td>{{ $cate->description }}</td>
                        <td>
                            @if($cate->status)
                                <span class="badge bg-success">Hiển thị</span>
                            @else
                                <span class="badge bg-danger">Không hiển thị</span>
                            @endif
                        </td>
                        <td class="d-flex justify-content-center gap-2">
                            {!! Form::open(['method'=>'DELETE','route' => ['country.destroy', $cate->id],'onsubmit' => 'return confirm("Xóa hay ko?")']) !!}
                                {!! Form::submit('Xóa', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                            <a href="{{ route('country.edit', $cate->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection