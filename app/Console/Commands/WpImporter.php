<?php

namespace LaravelVueJs\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use LaravelVueJs\Models\Post;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;

class WpImporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import wp posts from xml file';

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
        $file = $this->argument('file');


        ini_set('memory_limit', '-1');

        $this->info('>>>>>>>>>>> START ');

        $handle = fopen($file, "r");
        $header = true;

        /*[
              0 => "ID"
              1 => "Title"
              2 => "Content"
              3 => "Excerpt"
              4 => "Date"
              5 => "Post Type"
              6 => "Permalink"
              7 => "Image URL"
              8 => "Image ID"
              9 => "Image Title"
              10 => "Image Caption"
              11 => "Image Description"
              12 => "Image Alt Text"
              13 => "Image Featured"
              14 => "Categories"
              15 => "Tags"
              16 => "Prominent words"
              17 => "original_link"
              18 => "Slug"
              19 => "Status"
              20 => "tie_views"
            ]
        */
        while ($csvLine = fgetcsv($handle, 0, ",")) {
            if ($header) {
                $header = false;
            } else {
                $slug = $csvLine[18];
                $title = $csvLine[1];

                $exist = Post::whereSlug($slug)->count();

                if ($exist) {
                    $this->info('#Exist :' . $title);
                    continue;
                }

                $this->info('#New :' . $title);


                $created_at = new Carbon($csvLine[4]);

                $content = str_replace(array('[ad_1]', '[ad_2]', '[ad_3]', '#9b59b6', '#408bb7', '#b70900'), array('', '', '', '#63F9E6', '#6936D3', '#384457'), $csvLine[2]);

                $excerpt = empty($csvLine[3]) ? trim(strip_tags(substr($content, 0, 400))) : $csvLine[3];


                $post_data = [
                    'user_id' => 1,
                    'title' => $title,
                    'slug' => $slug,
                    'excerpt' => $excerpt,
                    'content' => $content,
                    'views' => $csvLine[20] ? ((int)$csvLine[20] + 8000) : random_int(500, 8000),
                    'source' => $csvLine[17] ?? null,
                    'type' => 1,
                    'status' => 1,
                    'comment_status' => 1,
                    'created_at' => $created_at->year < 0 ? Carbon::create(2016, 03, 22) : $created_at,
                    'updated_at' => Carbon::now(),
                ];

                /** @var Post $post */
                $post = Post::create($post_data);

                $image = $csvLine[7];
                if (!empty($image)) {
                    $image = str_replace(' ', '%20', $image);
                    try {
                        $post->addMediaFromUrl($image)->toMediaCollection(Post::MEDIA_COLLECTION);
                    } catch (FileCannotBeAdded $e) {
                        $this->warn($e->getMessage());
                        $this->warn('URL : ' . $csvLine[7]);
                    }
                }

                if (!empty($csvLine[14])) {
                    $categories = explode('|', $csvLine[14]);
                    $post->attachCategories($categories);
                }

                $tags = [];
                if (!empty($csvLine[15])) {
                    $tags = explode('|', $csvLine[15]);
                }

                if (!empty($csvLine[16])) {
                    $tags = $tags + explode('|', $csvLine[16]);
                }

                $post->attachTags($tags);
            }
        }

        $this->info('>>>>>>>>>>>>>>>>>>>>> DONE ');

    }
}
