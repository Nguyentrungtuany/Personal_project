<x-app-layout>
    <x-slot name="header">
        <a href="{{route('movie.index')}}" class="text-gray-900 dark:text-gray-100">Liệt kê</a>

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quản lý Phim') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(!isset($movie))
                    {!! Form::open(['route'=>'movie.store','method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
                    @else

                    {!! Form::open(['route'=>['movie.update',$movie->id],'method'=>'PUT', 'enctype' => 'multipart/form-data']) !!}
                    @endif

                        {{-- Title --}}
                        <div class="mb-5">
                            {!! Form::label('title', 'Title', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::text('title', isset($movie) ? $movie->title : '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                'placeholder' => 'Nhập tên danh mục',
                                'id' => 'slug','onkeyup' => 'ChangeToSlug()'
                            ]) !!}
                        </div>
                        <div class="mb-5">
                            {!! Form::label('thoiluong', 'Thời lượng phim', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::text('thoiluong', isset($movie) ? $movie->thoiluong : '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                'placeholder' => 'Nhập thời lượng phim',                            ]) !!}
                        </div>
                        <div class="mb-5">
                            {!! Form::label('Tên tiếng anh', 'Tên tiếng anh', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::text('name_eng', isset($movie) ? $movie->name_eng : '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                'placeholder' => 'Nhập tên danh mục',
                                'id' => 'name_eng',
                            ]) !!}
                        </div>
                        <div class="mb-5">
                            {!! Form::label('Trailer', 'Trailer', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::text('trailer', isset($movie) ? $movie->trailer : '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                'placeholder' => 'Nhập trailer',
                            ]) !!}
                        </div>
                        <div class="mb-5">
                            {!! Form::label('sotap', 'Số tập phim', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::text('sotap', isset($movie) ? $movie->sotap : '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                'placeholder' => 'Nhập số tập phim',
                            ]) !!}
                        </div>
                        <div class="mb-5">
                            {!! Form::label('slug', 'Slug', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::text('slug', isset($movie) ? $movie->slug : '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                'placeholder' => 'Nhập slug danh mục',
                                'id' => 'convert_slug'
                            ]) !!}
                        </div>
                        {{-- Description --}}
                        <div class="mb-5">
                            {!! Form::label('description', 'Mô tả', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::textarea('description', isset($movie) ? $movie->description : '', [
                                'rows' => 4,
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white resize-none',
                                'placeholder' => 'Nhập mô tả danh mục',
                                'id' => 'description'
                            ]) !!}
                        </div>
                        <div class="mb-5">
                            {!! Form::label('tags', 'Tags phim', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::textarea('tags', isset($movie) ? $movie->tags : '', [
                                'rows' => 4,
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white resize-none',
                                'placeholder' => 'Nhập tags',
                            ]) !!}
                        </div>
                        <div class="mb-5">
                            {!! Form::label('Active', 'Active', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::Select('status', ['1' => 'Hiển thị', '0' => 'Không hiển thị'], isset($movie) ? $movie->status : '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                
                            ]) !!}
                        </div>
                         <div class="mb-5">
                            {!! Form::label('resolution', 'resolution', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::Select('resolution', ['0' => 'HD', '1' => 'SD','2'=>'HDcam','3'=>'Cam','4'=>'FullHD','5'=>'Trailer'], isset($movie) ? $movie->resolution : '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                
                            ]) !!}
                        </div>
                        <div class="mb-5">
                            {!! Form::label('phude', 'Phụ đề', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::Select('phude', ['0' => 'Phụ đề', '1' => 'Thuyết minh'], isset($movie) ? $movie->phude : '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                
                            ]) !!}
                        </div>
                        <div class="mb-5">
                            {!! Form::label('Category', 'Danh mục', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::Select('category_id',$category, isset($movie) ? $movie->category_id : '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                
                            ]) !!}
                        </div>
                        <div class="mb-5">
                            {!! Form::label('thuocphim', 'Thuộc phim', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::Select('thuocphim', ['phimle' => 'Phim lẻ', 'phimbo' => 'Phim bộ'], isset($movie) ? $movie->thuocphim : '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                
                            ]) !!}
                        </div>
                        <div class="mb-5">
                            {!! Form::label('Country', 'Quốc gia', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::Select('country_id', $country, isset($movie) ? $movie->country_id: '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                
                            ]) !!}
                        </div>
                        <div class="mb-5">
                            {!! Form::label('Genre', 'Thể loại', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {{-- {!! Form::Select('genre_id', $genre, isset($movie) ? $movie->genre_id: '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                
                            ]) !!} --}}
                             @foreach($list_genre as $key => $gen)
                             @if(isset($movie))
                                {!! Form::checkbox('genre[]', $gen->id ,isset($movie_genre) && $movie_genre->contains($gen->id) ?  true:false) !!}
                            @else
                                {!! Form::checkbox('genre[]', $gen->id ,'') !!}
                            @endif
                                {!! Form::label('genre', $gen->title) !!}
                            
                            
                             @endforeach
                        </div>
                        <div class="mb-5">
                            {!! Form::label('Hot', 'Hot', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::Select('phim_hot', ['1' => 'Có', '0' => 'Không '], isset($movie) ? $movie->phim_hot : '', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                                
                            ]) !!}
                        </div>
                        <div class="mb-5">
                            {!! Form::label('image', 'image ', ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300']) !!}
                            {!! Form::file('image', [
                                'class' => 'w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white',
                            ]) !!}
                            @if($movie)
                                <img width="20%" src="{{ asset('uploads/movie/'.$movie->image) }}" alt="">
                            @endif
                        </div>
                        {{-- Submit --}}
                    @if(!isset($movie))

                        <div>
                            {!! Form::submit('Thêm dữ liệu', [
                                'class' => 'px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition'
                            ]) !!}

                    @else
                            <div>
                            {!! Form::submit('Cập nhập', [
                                'class' => 'px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition'
                            ]) !!}
                    @endif
                    {!! Form::close() !!}

                </div>
            </div>  
        </div>
        

    </div>
</x-app-layout>
 