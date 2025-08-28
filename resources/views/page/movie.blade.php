@extends('layout')
@section('content')

<div class="row container" id="wrapper">
            <div class="halim-panel-filter">
               <div class="panel-heading">
                  <div class="row">
                     <div class="col-xs-6">
                        <div class="yoast_breadcrumb hidden-xs"><span><span>
                           <a href="{{route('category',[$movie->category->slug])}}">{{$movie->category->title}}</a> » <span>
                              <a href="{{route('country',[$movie->country->slug])}}">{{$movie->country->title}}</a> » 
                              
                           @foreach($movie->movie_genre as $gen )
                              <a href="{{route('genre',[$gen->slug])}}">{{$gen->title}}</a> » 
                           @endforeach
                           <span class="breadcrumb_last" aria-current="page">{{$movie->title}}</span></span></span></span></div>
                     </div>
                  </div>
               </div>
               <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                  <div class="ajax"></div>
               </div>
            </div>
            <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
               <section id="content" class="test">
                  <div class="clearfix wrap-content">
                    
                     <div class="halim-movie-wrapper">
                        <div class="title-block">
                           <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="38424">
                              <div class="halim-pulse-ring"></div>
                           </div>
                           <div class="title-wrapper" style="font-weight: bold;">
                              Bookmark
                           </div>
                        </div>
                        <div class="movie_info col-xs-12">
                           <div class="movie-poster col-md-3">
                              <img class="movie-thumb" src="{{asset('uploads/movie/'.$movie->image)}}" alt="{{$movie->title}}" title="{{$movie->title}}">
                              @if($movie->resolution!=5)
                              @if($episode_current_list_count>0)
                              <div class="bwa-content">
                                 <div class="loader"></div>
                                 <a href="{{ url('xem-phim/'.$movie->slug.'/tap-'.$episode_tapdau->episode) }}" class="bwac-btn">
                                 <i class="fa fa-play"></i>
                                 </a>
                              </div>
                              @endif

                              @else
                              <a href="#watch_trailer" style="display:block ;" class="btn btn-primary watch-trailer">Xem Trailer</a>
                              @endif
                           </div>
                           <div class="film-poster col-md-9">
                              <h1 class="movie-title title-1" style="display:block;line-height:35px;margin-bottom: -14px;color: #ffed4d;text-transform: uppercase;font-size: 18px;">{{$movie->title}}</h1>
                              <h2 class="movie-title title-2" style="font-size: 12px;">{{$movie->name_eng}}</h2>
                              <ul class="list-info-group">
                                 <li class="list-info-group-item"><span>Trạng Thái</span> : <span class="quality">@if($movie->resolution==0)
                                       HD
                                    @elseif($movie->resolution==1)
                                        SD
                                    @elseif($movie->resolution==2)
                                        HDcam
                                    @elseif($movie->resolution==3)
                                        Cam
                                    @elseif($movie->resolution==4)
                                        FullHD
                                    @else
                                        Trailer
                                    @endif
                                 @if($movie->resolution!=5)
                                 </span><span class="episode">@if($movie->phude==0)
                                Phụ đề
                                
                                @else
                                Thuyết minh
                                 
                                @endif</span>
                                @endif
                              </li>
                                 <li class="list-info-group-item"><span>Thời lượng</span> : {{$movie->thoiluong}} </li>
                                 @if($movie->season!=0)
                                 <li class="list-info-group-item"><span>Season</span> : {{$movie->season}} </li>
                                 @endif
                                 <li class="list-info-group-item"><span>Số tập</span> : 
                              @if($movie->thuocphim=='phimbo')
                                       
                                    
                                    {{$episode_current_list_count}}/{{$movie->sotap}} - 
                                    @if($episode_current_list_count==$movie->sotap) 
                                    Hoàn Thành
                                    @else
                                    Chưa Hoàn Thành
                                    @endif
                              @else
                                 FullHD
                                 HD
                               @endif
                               

                              </li>

                                 <li
                                    class="list-info-group-item"><span>Thể loại</span> :
                                    @foreach($movie->movie_genre as $key => $gen)
                                       <a href="{{route('genre',[$gen->slug])}}" rel="category tag">{{$gen->title}}</a>
                                    @endforeach
                                 </li>
                                 <li 
                                    class="list-info-group-item"><span>Danh mục</span> : <a href="{{route('category',[$movie->category->slug])}}" rel="category tag">{{$movie->category->title}}</a>
                                 </li>
                                 <li class="list-info-group-item"><span>Quốc gia</span> : <a href="{{route('country',[$movie->country->slug])}}" rel="tag">{{$movie->country->title}}</a></li>
                                 <li class="list-info-group-item"><span>Tập phim mới nhất</span> : 
                                
                                    
                                 

                                    @if($episode_current_list_count>0)                                    
                                    @if($movie->thuocphim=='phimbo')

                                       @foreach($episode as $key => $ep)
                                          <a href="{{url('xem-phim/'.$ep->movie->slug.'/tap-'.$ep->episode)}}" rel="tag"> Tập {{$ep->episode}} </a>

                                       @endforeach  
                                    

                                    @elseif($movie->thuocphim=='phimle')
                                       @foreach($episode as $key => $ep_le)

                                    <a href="{{ url('xem-phim/'.$movie->slug.'/tap-'.$ep_le->episode) }}" rel="tag"> {{$ep_le->episode}} </a>
                                       @endforeach  
                                    
                                    @endif

                                    @else

                                    Đang cập nhập 
                                    @endif
                                 </li>
                              </ul>
                              <div class="movie-trailer hidden"></div>
                           </div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <div id="halim_trailer"></div>
                     <div class="clearfix"></div>
                     <div class="section-bar clearfix">
                        <h2 class="section-title"><span style="color:#ffed4d">Nội dung phim</span></h2>
                     </div>
                     <div class="entry-content htmlwrap clearfix">
                        <div class="video-item halim-entry-box">
                           <article id="post-38424" class="item-content">
                              {{$movie->description}}
                              
                           </article>
                        </div>
                        <div class="section-bar clearfix">
                        <h2 class="section-title"><span style="color:#ffed4d">Tags phim</span></h2>
                     </div>
                     <div class="entry-content htmlwrap clearfix">
                        <div class="video-item halim-entry-box">
                           <article id="post-38424" class="item-content">
                              @if($movie->tags!=null)
                              @php
                                 $tags = array();
                                 $tags = explode(',', $movie->tags);
                              @endphp
                              @foreach($tags as $key => $tag)
                                 <a href="{{url('tag/'.$tag)}}">{{$tag}}</a>
                              @endforeach
                              @else
                              {{$movie->title}}
                              @endif
                           </article>
                        </div>
                     </div>
                     <div class="section-bar clearfix">
                        <h2 class="section-title"><span style="color:#ffed4d">Bình luận phim</span></h2>
                     </div>
                     <div class="entry-content htmlwrap clearfix">
                        <div class="video-item halim-entry-box">
                           <article id="post-38424" class="item-content">
                              @php
                                 $current = Request::url();

                              @endphp
                              <div class="fb-comments" data-colorscheme="light" data-href="{{$current}}" data-width="100%" data-numposts="10"></div>
                           </article>
                        </div>
                     </div>
                     <div class="section-bar clearfix">
                        <h2 class="section-title"><span style="color:#ffed4d">Trailer phim</span></h2>
                     </div>
                     <div class="entry-content htmlwrap clearfix">
                        <div class="video-item halim-entry-box">
                           <article id="watch_trailer" class="item-content">
                           <iframe width="100%" height="350" src="https://www.youtube.com/embed/{{$movie->trailer}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>                        </div>
                     </div>
                  </div>
               </section>
               <section class="related-movies">
                  <div id="halim_related_movies-2xx" class="wrap-slider">
                     <div class="section-bar clearfix">
                        <h3 class="section-title"><span>CÓ THỂ BẠN MUỐN XEM</span></h3>
                     </div>                        


                     <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
                        @foreach($related as $key => $movie)
                        <article class="thumb grid-item post-38498">
                           <div class="halim-item">
                              <a class="halim-thumb" href="{{ route('movie',$movie->slug) }}" title="{{ $movie->title }}">
                                 <figure><img class="lazy img-responsive" src="{{ asset('uploads/movie/'.$movie->image) }}" alt="{{ $movie->title }}" title="{{ $movie->title }}"></figure>
                                 <span class="status">@if($movie->resolution==0)
                                       HD
                                    @elseif($movie->resolution==1)
                                        SD
                                    @elseif($movie->resolution==2)
                                        HDcam
                                    @elseif($movie->resolution==3)
                                        Cam
                                    @elseif($movie->resolution==4)
                                        FullHD
                                    @else
                                        Trailer
                                    @endif</span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i>@if($movie->phude==0)
                                Phụ đề
                                @if($movie->season!=0)
                                    - Season {{ $movie->season }}
                                @endif
                                @else
                                Thuyết minh
                                 @if($movie->season!=0)
                                    - Season {{ $movie->season }}
                                @endif
                                @endif</span>
                                 <div class="icon_overlay"></div>
                                 <div class="halim-post-title-box">
                                    <div class="halim-post-title ">
                                       <p class="entry-title">{{ $movie->title }}</p>
                                       <p class="original_title">{{ $movie->name_eng}}</p>
                                    </div>
                                 </div>
                              </a>
                           </div>
                        </article>
                        @endforeach
                       
                     </div>
                    
                  </div>
               </section>
               
            </main>
            @include('page.include.sidebar')

         </div>
@endsection
