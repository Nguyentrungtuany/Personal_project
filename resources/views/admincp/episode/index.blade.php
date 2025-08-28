<x-app-layout>
    <x-slot name="header">
        <a href="{{route('episode.create')}}" class="text-gray-900 dark:text-gray-100">Thêm tập</a>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quản lý danh mục') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                {{-- thêm wrapper để bảng rộng full --}}
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle text-center" id="tablephim" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên phim</th>
                                <th scope="col">Ảnh phim</th>
                                <th scope="col">Tập phim</th>
                                <th scope="col">Link phim</th>
                                <th scope="col">Quản lý</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list_episode as $key => $episode)
                            <tr>
      <th scope="row">{{ $key  }}</th>
      <td>{{ $episode->movie->title }}</td>
      <td><img width="80px" src="{{ asset('uploads/movie/'.$episode->movie->image) }}" alt=""></td>

      <td>{{ $episode->episode }}</td>
      <td>{!! $episode->linkphim !!}</td>
      
      <td>
        {!! Form::open(['method'=>'DELETE','route' => ['episode.destroy', $episode->id],'onsubmit' => 'return confirm("Xóa hay ko?")']) !!}
            {!! Form::submit('Xóa', ['class' => 'btn btn-danger btn-sm']) !!}
        {!! Form::close() !!}
        <a href="{{ route('episode.edit', $episode->id) }}" class="btn btn-warning btn-sm">Sửa</a>
      </td>
    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>