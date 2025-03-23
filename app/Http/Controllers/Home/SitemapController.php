<?php

namespace App\Http\Controllers\Home;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class SitemapController extends Controller
{
    public function index()
    {
        // create sitemap
        $sitemap = App::make("sitemap");

        // set cache
        $sitemap->setCache('laravel.sitemap-index', false);

        // add sitemaps (loc, lastmod (optional))
        $sitemap->addSitemap(URL::to('sitemap-products'));
        $sitemap->addSitemap(URL::to('sitemap-tags'));

        // show sitemap
        return $sitemap->render('sitemapindex');
    }

    public function tags()
    {
        // create sitemap
        $sitemap_tags = App::make('sitemap');

        // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
        // by default cache is disabled. $sitemap->setCache('laravel.sitemap', 60); cache is set to 1 hour
        $sitemap_tags->setCache('laravel.sitemap-tags', false);

        // add items
        if (!$sitemap_tags->isCached()) {
            $tags = Tag::all();
            foreach ($tags as $tag) {
//                $sitemap_tags->add(URL::to('tags/' . $tag->slug), $tag->updated_at, '0.5', 'weekly'); TODO: add slug for tags and create route for tags
                $sitemap_tags->add(URL::to('tags/' . $tag->name), $tag->updated_at, '0.5', 'weekly');
            }
        }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap_tags->render('xml');
    }

    public function products()
    {
        // create sitemap
        $sitemap_products = App::make('sitemap');

        // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
        // by default cache is disabled. $sitemap->setCache('laravel.sitemap', 60); cache is set to 1 hour
        $sitemap_products->setCache('laravel.sitemap-products', false);

        // add items
        if (!$sitemap_products->isCached()) {
            // get all posts from db
            $products = Product::all();

            // add every post to the sitemap
            foreach ($products as $product) {
                $images = [];
                $images[] = ['url' => asset($product->primary_image), 'title' => 'تصویر اصلی - ' . $product->name, 'caption' => 'تصویر اصلی'];
                foreach ($product->productImages as $image) {
                    $images[] = ['url' => asset($image->image), 'title' => $product->name];
                }
                $sitemap_products->add(URL::to('products/' . $product->slug), $product->updated_at, '1.0', 'daily', $images);
            }
        }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap_products->render('xml');
    }
}
