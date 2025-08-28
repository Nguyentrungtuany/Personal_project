<x-app-layout>
    <x-slot name="header">
        <a href="{{route('movie.index')}}" class="text-gray-900 dark:text-gray-100">Liệt kê</a>

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quản lý danh mục') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(!isset($category))
                    {!! Form::open(['route'=>'category.store','method'=>'POST']) !!}
                    @else

                    {!! Form::open(['route'=>['category.update',$category->id],'method'=>'PUT']) !!}
                    @endif

                    {{-- Title --}}
                    <div class="mb-5">
                        {!! Form::label('title', 'Title', ['class' => 'block mb-2 text-sm font-medium text-gray-900
                        dark:text-gray-300']) !!}
                        {!! Form::text('title', isset($category) ? $category->title : '', [
                        'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500
                        dark:bg-gray-700 dark:text-white',
                        'placeholder' => 'Nhập tên danh mục',
                        'id' => 'slug','onkeyup' => 'ChangeToSlug()'
                        ]) !!}
                    </div>
                    <div class="mb-5">
                        {!! Form::label('slug', 'Slug', ['class' => 'block mb-2 text-sm font-medium text-gray-900
                        dark:text-gray-300']) !!}
                        {!! Form::text('slug', isset($category) ? $category->slug : '', [
                        'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500
                        dark:bg-gray-700 dark:text-white',
                        'placeholder' => 'Nhập slug danh mục',
                        'id' => 'convert_slug'
                        ]) !!}
                    </div>
                    {{-- Description --}}
                    <div class="mb-5">
                        {!! Form::label('description', 'Mô tả', ['class' => 'block mb-2 text-sm font-medium
                        text-gray-900 dark:text-gray-300']) !!}
                        {!! Form::textarea('description', isset($category) ? $category->description : '', [
                        'rows' => 4,
                        'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500
                        dark:bg-gray-700 dark:text-white resize-none',
                        'placeholder' => 'Nhập mô tả danh mục',
                        'id' => 'description'
                        ]) !!}
                    </div>

                    <div class="mb-5">
                        {!! Form::label('Active', 'Active', ['class' => 'block mb-2 text-sm font-medium text-gray-900
                        dark:text-gray-300']) !!}
                        {!! Form::Select('status', ['1' => 'Hiển thị', '0' => 'Không hiển thị'], isset($category) ?
                        $category->status : '', [
                        'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500
                        dark:bg-gray-700 dark:text-white',

                        ]) !!}
                    </div>

                    {{-- Submit --}}
                    @if(!isset($category))

                    <div>
                        {!! Form::submit('Thêm dữ liệu', [
                        'class' => 'px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700
                        focus:outline-none focus:ring-2 focus:ring-green-500 transition'
                        ]) !!}

                        @else
                        <div>
                            {!! Form::submit('Cập nhập', [
                            'class' => 'px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700
                            focus:outline-none focus:ring-2 focus:ring-green-500 transition'
                            ]) !!}
                            @endif
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover align-middle text-center">
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
</table>


            </div>
</x-app-layout>