<x-app-layout>
    <x-slot name="header">
        <a href="{{route('movie.index')}}" class="text-gray-900 dark:text-gray-100">Liệt kê</a>

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quản lý thông tin website') }}
        </h2>
    </x-slot>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        {!! Form::open(['route'=>['info.update',$info->id],'method'=>'PUT', 'enctype' => 'multipart/form-data']) !!}

                    {{-- Title --}}
                    <div class="mb-5">
                        {!! Form::label('title', 'Tiêu đề website', ['class' => 'block mb-2 text-sm font-medium text-gray-900
                        dark:text-gray-300']) !!}
                        {!! Form::text('title', isset($info) ? $info->title : '', [
                        'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500
                        dark:bg-gray-700 dark:text-white',
                        ]) !!}
                    </div>
                    
                    {{-- Description --}}
                    <div class="mb-5">
                        {!! Form::label('description', 'Mô tả Website', ['class' => 'block mb-2 text-sm font-medium
                        text-gray-900 dark:text-gray-300']) !!}
                        {!! Form::textarea('description', isset($info) ? $info->description : '', [
                        'rows' => 4,
                        'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500
                        dark:bg-gray-700 dark:text-white resize-none'
                        ]) !!}
                    </div>
                    <div class="mb-5">
                        {!! Form::label('copyright', 'Copyright', ['class' => 'block mb-2 text-sm font-medium text-gray-900
                        dark:text-gray-300']) !!}
                        {!! Form::text('copyright', isset($info) ? $info->copyright : '', [
                        'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500
                        dark:bg-gray-700 dark:text-white',
                        ]) !!}
                    </div>
                  <div class="mb-5">
                            {!! Form::label('image', 'Hình ảnh logo ', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::file('image', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                            ]) !!}
                            @if($info)
                                <img width="20%" src="{{ asset('uploads/logo/'.$info->logo) }}" alt="">
                            @endif
                        </div>

                    {{-- Submit --}}

                    <div class="mb-5">
                        <div>
                            {!! Form::submit('Cập nhập', [
                            'class' => 'px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700
                            focus:outline-none focus:ring-2 focus:ring-green-500 transition'
                            ]) !!}
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
                {{-- <table class="table table-striped table-bordered table-hover align-middle text-center">
  <thead class="table-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Slug</th>
      <th scope="col">Description</th>
      <th scope="col">Acction/Inactive</th>
      <th scope="col">Manage</th>
    </tr>
  </thead>
  <tbody class="order_position">
    @foreach($list as $key => $cate)
    
    
    <tr id="{{$cate->id}}">
      <th scope="row">{{ $key  }}</th>
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
      <td>
        {!! Form::open(['method'=>'DELETE','route' => ['country.destroy', $cate->id],'onsubmit' => 'return confirm("Xóa hay ko?")']) !!}
            {!! Form::submit('Xóa', ['class' => 'btn btn-danger btn-sm']) !!}
        {!! Form::close() !!}
        <a href="{{ route('country.edit', $cate->id) }}" class="btn btn-warning btn-sm">Sửa</a>
      </td>
    </tr>
   @endforeach
  </tbody>
</table> --}}


            </div>
</x-app-layout>