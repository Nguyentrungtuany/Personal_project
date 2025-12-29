<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Movie_Genre;use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class CreateSiteMap extends Command
{
    protected $signature = 'sitemap:create';
    protected $description = 'Tạo sitemap.xml cho website';

    public function handle()
    {
        // Khởi tạo sitemap
        $sitemap = Sitemap::create();

        // Trang chủ
        $sitemap->add(
            Url::create(route('homepage'))
                ->setLastModificationDate(Carbon::now('Asia/Ho_Chi_Minh'))
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        // Thêm các thể loại (genres)
        $genres = Genre::orderBy('id', 'DESC')->get();

        foreach ($genres as $gen) {
            $sitemap->add(
                Url::create(url('/the-loai/' . $gen->slug))
                    ->setLastModificationDate(Carbon::now('Asia/Ho_Chi_Minh'))
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            );
        }
        // Thêm các thể loại (category)
        $category = Category::orderBy('id', 'DESC')->get();

        foreach ($category as $cate) {
            $sitemap->add(
                Url::create(url('/danh-muc/' . $cate->slug))
                    ->setLastModificationDate(Carbon::now('Asia/Ho_Chi_Minh'))
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            );
        }
        // Thêm các thể loại (country)
        $country = Country::orderBy('id', 'DESC')->get();

        foreach ($country as $coun) {
            $sitemap->add(
                Url::create(url('/quoc-gia/' . $coun->slug))
                    ->setLastModificationDate(Carbon::now('Asia/Ho_Chi_Minh'))
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            );
        }
        // Thêm các thể loại (movie)
        $movie = Movie::orderBy('id', 'DESC')->get();

        foreach ($movie as $mov) {
            $sitemap->add(
                Url::create(url('/phim/' . $mov->slug))
                    ->setLastModificationDate(Carbon::now('Asia/Ho_Chi_Minh'))
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            );
        }// Thêm các thể loại (movie)
        $movie_ep = Movie::orderBy('id', 'DESC')->get();
        $episode = Episode::all();
        foreach ($movie_ep as $mov_ep) {
            foreach ($episode as $ep) {
                if ($mov_ep->id == $ep->movie_id) {
                    $sitemap->add(

                        Url::create(url("/xem-phim/{$mov_ep->slug}/tap-{$ep->episode}"))
                            ->setLastModificationDate(Carbon::now('Asia/Ho_Chi_Minh'))
                            ->setPriority(0.7)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    );
                }
            }
        }
          // Xuất sitemap ra public/sitemap.xml
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ Sitemap đã được tạo tại public/sitemap.xml');
    }
}
