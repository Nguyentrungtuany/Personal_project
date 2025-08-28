<x-app-layout>
    <x-slot name="header">
        <a href="{{route('episode.index')}}" class="text-gray-900 dark:text-gray-100">Liệt kê Danh Sách Tập Phim</a>

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quản lý tập phim') }}
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
                        {!! Form::label('movie', 'Chọn phim', ['class' => 'select-movie block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                        {!! Form::Select('movie_id',['0'=>'Chọn phim','Danh sách phim'=> $list_movie], isset($episode) ? $episode->movie_id : '', [ 'class' => 'select-movie w-full p-2 border border-gray-300 rounded-lg focus:ring-2
                        focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',

                        ]) !!}
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
                        <select name="episode" id="show_movie" class="form-control"></select>
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

</x-app-layout>