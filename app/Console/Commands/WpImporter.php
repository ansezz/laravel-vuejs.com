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

        try {
            ini_set('memory_limit', '-1');

            $this->info('>>>>>>>>>>> START ');
            /** @var string $path */
            // $path = storage_path('app' . DIRECTORY_SEPARATOR . 'wp-importer' . DIRECTORY_SEPARATOR . 'in-progress' . DIRECTORY_SEPARATOR . $this->file_name);

            $path = $file;

            echo $path . '  ';

            if (file_exists($path)) {
                $xml = simplexml_load_file($path);

                foreach ($xml->channel->item as $item) {

                    $this->info($item->title);


                    $categories = [];
                    $tags = [];
                    foreach ($item->category as $cat) {
                        if ($cat['domain'] == 'category') {
                            $categories[] = (string)$cat['nicename'];
                        }

                        if ($cat['domain'] == 'post_tag') {
                            $tags[] = (string)$cat['nicename'];
                        }
                    }

                    $e_content = $item->children('content', true);
                    $e_excerpt = $item->children('excerpt', true);

                    $wp = $item->children("wp", true);


                    $wp_postmeta = [];
                    foreach ($wp->postmeta as $value) {
                        $wp_postmeta[(string)$value->meta_key] = (string)$value->meta_value;
                    }

                    $created_at = new Carbon($wp->post_date_gmt);

                    $wp = $item->children('wp', true);

                    $content = (string)$e_content->encoded;
                    $content = str_replace(array('[ad_1]', '[ad_2]', '[ad_3]', '#9b59b6', '#408bb7', '#b70900'), array('', '', '', '#63F9E6', '#6936D3', '#384457'), $content);

                    $excerpt = trim((string)$e_excerpt->encoded);

                    /** @var Post $post */
                    $post = Post::create([
                        'user_id' => 1,
                        'title' => (string)$item->title,
                        'slug' => (string)$wp->post_name,
                        'excerpt' => empty($excerpt) ? trim(strip_tags(substr($content, 0, 400))) : $excerpt,
                        'content' => $content,
                        'views' => $wp_postmeta['tie_views'] ? ((int)$wp_postmeta['tie_views'] + 8000) : random_int(500, 8000),
                        'source' => $wp_postmeta['original_link'] ?? null,
                        'type' => 1,
                        'status' => 1,
                        'comment_status' => 1,
                        'created_at' => $created_at,
                        'updated_at' => Carbon::now(),
                    ]);

                    preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $content, $image);

                    try {
                        $post->addMediaFromUrl($image['src'])
                            ->toMediaCollection(Post::MEDIA_COLLECTION);
                    } catch (FileCannotBeAdded $e) {
                        $this->warn($e->getMessage());
                    }

                    $post->attachTags($tags);
                    $post->attachCategories($categories);
                }


                $this->info('>>>>>>>>>>>>>>>>>>>>> DONE ');

                /*Storage::disk('local')->move(
                    'wp-importer' . DIRECTORY_SEPARATOR . 'in-progress' . DIRECTORY_SEPARATOR . $this->file_name,
                    'wp-importer' . DIRECTORY_SEPARATOR . 'done' . DIRECTORY_SEPARATOR . $this->file_name
                );*/

            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }

    }
}
