<?php

namespace LaravelVueJs\Console\Commands;

use Carbon\Carbon;
use function Clue\StreamFilter\fun;
use Illuminate\Console\Command;
use LaravelVueJs\Models\Category;
use LaravelVueJs\Models\Post;
use LaravelVueJs\Models\Tag;
use Spatie\Crawler\Crawler;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Tags\Sitemap;


class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // Index site map
        $this->info("Generate Site map Index");
        $sitemap = SitemapIndex::create()
                 ->add(Sitemap::create('sitemap_posts.xml')
                     ->setLastModificationDate(Carbon::yesterday()))
                 ->add(Sitemap::create('sitemap_tags.xml')
                     ->setLastModificationDate(Carbon::yesterday()))
                 ->add(Sitemap::create('sitemap_categories.xml')
                     ->setLastModificationDate(Carbon::yesterday()));

        $sitemap->writeToFile(public_path('sitemap.xml'));


        // posts
        $this->info("Generate Posts Site map ");

        $posts = Post::limit(50)->get();

        $sitemap_posts = SitemapGenerator::create(config('app.url'))->getSitemap();
        $posts->each(function ($post) use (&$sitemap_posts) {
            $sitemap_posts->add(Url::create($post->url)->setLastModificationDate($post->updated_at));
        });

        $sitemap_posts->writeToFile(public_path('sitemap_posts.xml'));



        // categories
        $this->info("Generate Categories Site map ");
        $categories = Category::all();

        $sitemap_categories = SitemapGenerator::create(config('app.url'))->getSitemap();

        $categories->each(function ($cat) use (&$sitemap_categories) {
            $sitemap_categories->add(Url::create($cat->url)->setLastModificationDate($cat->updated_at));
        });

        $sitemap_categories->writeToFile(public_path('sitemap_categories.xml'));


        // tags
        $this->info("Generate Tags Site map ");
        $tags = Tag::all();

        $sitemap_tags = SitemapGenerator::create(config('app.url'))->getSitemap();

        $tags->each(function ($tag) use (&$sitemap_tags) {
            $sitemap_tags->add(Url::create($tag->url)->setLastModificationDate($tag->updated_at));
        });


    }
}
