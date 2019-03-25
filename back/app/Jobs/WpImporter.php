<?php

namespace LaravelVueJs\Jobs;

use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LaravelVueJs\Models\Post;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;
use Storage;

class WpImporter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file_name;

    /**
     * Create a new job instance.
     *
     * @param $file_name
     */
    public function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        echo '>>>>>>>>>>> START ';
        /** @var string $path */
        $path = storage_path('app' . DIRECTORY_SEPARATOR . 'wp-importer' . DIRECTORY_SEPARATOR . 'in-progress' . DIRECTORY_SEPARATOR . $this->file_name);

        echo $path . '  ';

        if (file_exists($path)) {
            $xml = simplexml_load_file($path);

            foreach ($xml->channel->item as $item) {

                /*foreach ($wp as $key => $value) {
                    echo (string)$key;
                    echo (string)$value;
                }*/

                echo (string)$item->title . ' ';
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

                $e_content = $item->children("content", true);
                $e_excerpt = $item->children("excerpt", true);

                $wp = $item->children("wp", true);


                $wp_postmeta = [];
                foreach ($wp->postmeta as $value) {
                    $wp_postmeta[(string)$value->meta_key] = (string)$value->meta_value;
                }

                $created_at = new Carbon($wp->post_date_gmt);

                $wp = $item->children("wp", true);

                $content = (string)$e_content->encoded;
                $content = str_replace(['[ad_1]', '[ad_2]', '[ad_3]'], '', $content);
                $content = str_replace(['#9b59b6', '#408bb7', '#b70900'], ['#63F9E6', '#6936D3', '#384457'], $content);

                /** @var Post $post */
                $post = Post::create([
                    'user_id' => 1,
                    'title' => (string)$item->title,
                    'slug' => (string)$wp->post_name,
                    'excerpt' => (string)$e_excerpt->encoded,
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
                    echo $e->getMessage();
                }

                $post->attachTags($tags);
                $post->attachCategories($categories);
            }

            echo '>>>>>>>>>>>>>>>>>>>>> DONE ';

            Storage::disk('local')->move(
                'wp-importer' . DIRECTORY_SEPARATOR . 'in-progress' . DIRECTORY_SEPARATOR . $this->file_name,
                'wp-importer' . DIRECTORY_SEPARATOR . 'done' . DIRECTORY_SEPARATOR . $this->file_name
            );

        }

    }
}
