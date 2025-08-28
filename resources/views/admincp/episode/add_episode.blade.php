<x-app-layout>
    <x-slot name="header">
        <a href="{{route('episode.create')}}" class="text-gray-900 dark:text-gray-100">Thêm tập</a>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quản lý Tập phim') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(!isset($episode))
                    {!! Form::open(['route'=>'episode.store','method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
                    @else

                    {!! Form::open(['route'=>['episode.update',$episode->id],'method'=>'PUT', 'enctype' =>
                    'multipart/form-data']) !!}
                    @endif


                    <div class="mb-5">
                        {!! Form::label('movie_title', 'Chọn phim', ['class' => 'select-movie block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                        {!! Form::text('movie_title', isset($movie) ? $movie->title : '', [ 'class' => 'select-movie w-full p-2 border border-gray-300 rounded-lg focus:ring-2
                        focus:ring-indigo-500 dark:bg-gray-700 dark:text-white','readonly'

                        ]) !!}
                        {!! Form::hidden('movie_id', isset($movie) ? $movie->id : '') !!}
                    </div>
                    <div class="mb-5">
                        {!! Form::label('link', 'Link phim', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                        {!! Form::text('link', isset($episode) ? $episode->linkphim : '', [ 'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white', 'placeholder' => 'Nhập link phim',
                        ]) !!}
                    </div>
                    @if(isset($episode))
                        
                   
                    <div class="mb-5">
                        {!! Form::label('episode', 'Tập phim', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                        {!! Form::text('episode', isset($episode) ? $episode->episode : '', [ 'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white', 'placeholder' => 'Nhập tập phim',isset($episode)? 'readonly' : ''
                        ]) !!}
                    </div>
                    @else
                    <div class="mb-5">
                        {!! Form::label('episode', 'Tập phim', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                        {!! Form::selectRange('episode', 1, $movie->sotap,$movie->sotap,['class' => 'form-control']) !!}
                    </div>
                    @endif
                    @if(!isset($episode))

                    <div>
                        {!! Form::submit('Thêm tập phim', [ 'class' => 'px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition'
                        ]) !!}

                        @else
                        <div>
                            {!! Form::submit('Cập nhập tập phim', [ 'class' => 'px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition'
                            ]) !!}
                            @endif
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>


            </div>
            {{-- liệt kê phim --}}
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